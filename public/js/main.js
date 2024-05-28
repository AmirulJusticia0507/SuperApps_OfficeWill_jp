function slugify(str) {
	return String(str)
		.normalize('NFKD') // split accented characters into their base characters and diacritical marks
		.replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
		.trim() // trim leading or trailing whitespace
		.toLowerCase() // convert to lowercase
		.replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
		.replace(/\s+/g, '-') // replace spaces with hyphens
		.replace(/-+/g, '-'); // remove consecutive hyphens
}

function companySlug({ modal_id }) {
	const modalCreate = document.getElementById(modal_id);
	const c = modalCreate.querySelector('#company_name');
	const u = modalCreate.querySelector('#company_username');
	const url = modalCreate.querySelector('#login_screen_url');
	const urlStorage = modalCreate.querySelector('#teaching_material_storage_file_path');
	if (modalCreate) {
		c.addEventListener('change', (e) => {
			console.debug(e.target.value)
			u.value = slugify(e.target.value);
			url.value = `${base_url}/login/${u.value}`;
			urlStorage.value = `${base_url}/storage/${u.value}/`;
		});
		u.addEventListener('change', (e) => {
			console.debug(e.target.value)
			u.value = slugify(e.target.value);
			url.value = `${base_url}/login/${u.value}`;
			urlStorage.value = `${base_url}/storage/${u.value}/`;
		});
	}
}

function modalFunc({ modal_id }) {
	companySlug({ modal_id });
}

function loadCourseAttribute(e) {
	var url = base_url + '/course-registration/attribute/' + e.value;
	$.ajax({
		type: "GET",
		url: url,
		success: function (res) {
			$('#attributeWrapper').empty();
			$('#attributeWrapper').html(res.html);
		},
		error: function (request, status, error) {
			console.error(request);
			console.error(status);
			console.error(error);
		}
	});
}

function courseSettingSetupAttendence() {
	let selectedCourses = [];
	let selectedEmployees = [];
	const formSetupAttendence = document.querySelector('#formSetupAttendence');
	if (!formSetupAttendence) {
		return;
	}
	const courseCbs = document.querySelectorAll('.course-checkbox');
	courseCbs.forEach((courseCb, index) => {
		courseCb.addEventListener('click', (e) => {
			if (e.target.checked) {
				selectedCourses.push(e.target.value);
			} else {
				selectedCourses.splice(selectedCourses.indexOf(e.target.value), 1)
			}
			// Set to input hidden
			const inputHidden = document.querySelectorAll('.selected-course');
			inputHidden.forEach(e => e.remove());
			selectedCourses.forEach(courseId => {
				var x = document.createElement("input");
				x.setAttribute("type", "hidden");
				x.name = "courses[]";
				x.value = courseId;
				x.classList.add('selected-course');
				formSetupAttendence.appendChild(x);
			});
		});
	});
	const employeeCbs = document.querySelectorAll('.employee-checkbox');
	employeeCbs.forEach((employeeCb, index) => {
		employeeCb.addEventListener('click', (e) => {
			if (e.target.checked) {
				selectedEmployees.push(e.target.value);
			} else {
				selectedEmployees.splice(selectedEmployees.indexOf(e.target.value), 1)
			}
			// Set to input hidden
			const inputHidden = document.querySelectorAll('.selected-employee');
			inputHidden.forEach(e => e.remove());
			selectedEmployees.forEach(courseId => {
				var x = document.createElement("input");
				x.setAttribute("type", "hidden");
				x.name = "employees[]";
				x.value = courseId;
				x.classList.add('selected-employee');
				formSetupAttendence.appendChild(x);
			});
		});
	});



}

function saveConfirm() {
	const saveConfirmBtns = document.querySelectorAll('.save-confirm');
	saveConfirmBtns.forEach(saveConfirmBtn => {
		saveConfirmBtn.addEventListener('click', function (e) {
			e.preventDefault();
			Swal.fire({
				title: e.target.getAttribute('data-confirm-title'),
				html: e.target.getAttribute('data-confirm-html'),
				showCancelButton: true,
				confirmButtonText: "OK",
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					if (e.target.href != null && e.target.href != '') {
						window.location.href = e.target.href;
					} else if (e.target.type == 'submit') {
						const form = e.target.closest('form');
						if (e.target.getAttribute('data-save') && e.target.getAttribute('data-save') == '0') {
							var x = document.createElement('input');
							x.type = 'hidden';
							x.name = 'save_type';
							x.value = 'temporary';
							form.appendChild(x);

						}
						form.submit();
					}
				}
			});
		});
	});

}

$(document).ready(function () {
	courseSettingSetupAttendence();
	saveConfirm();


	$('.date-picker').datepicker({
		format: 'yyyy-mm-dd',
	});
	$('.month-picker').datepicker({
		format: 'yyyy-mm',
		viewMode: 'months',
		minViewMode: 'months'
	});
	$('.year-picker').datepicker({
		format: 'yyyy',
		viewMode: 'years',
		minViewMode: 'years'
	});


	$('.open-modal').click(function () {
		var url = $(this).data("url");

		$.ajax({
			type: "GET",
			url: url,
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			success: function (res) {
				$('#showModalHere').empty();
				$('#showModalHere').html(res.html);
				$(`#${res.data.modal_id}`).modal('show');
				modalFunc({ modal_id: res.data.modal_id });
			},
			error: function (request, status, error) {
				console.error(request);
				console.error(status);
				console.error(error);
			}
		});
	});
});
