<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation; // Import model EmployeeInformation
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use Illuminate\Support\Facades\Redirect;

class MasterRegistrationController extends Controller
{
    /**
     * Menampilkan halaman registrasi anggota.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        // Tampilkan halaman registrasi
        return view('member-registration', compact('affiliations', 'jobTitles'));
    }

    public function create()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        // Tampilkan halaman formulir pembuatan karyawan baru
        return view('member-registration', compact('affiliations', 'jobTitles'));
    }


    /**
     * Menyimpan data registrasi anggota yang baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form registrasi
        $validatedData = $request->validate([
            // Aturan validasi untuk setiap field formulir
            'full_name' => 'required|string|max:255',
            'kana_name' => 'nullable|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:employee_information',
            'contact_phone_number' => 'nullable|string|max:20',
            'employee_code' => 'required|string|max:50|unique:employee_information',
            'sex' => 'nullable|string|max:10',
            'date_of_birth' => 'nullable|date',
            'date_of_joining' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'encrypted_password' => 'required|string|max:255',
            'account_status' => 'required|string|max:20',
            'password_expiration_date' => 'nullable|date',
            'number_of_incorrect_passwords' => 'required|integer',
            'account_lock_date_time' => 'nullable|date',
            'employee_attribute01' => 'nullable|string|max:255',
            'employee_attribute02' => 'nullable|string|max:255',
            'employee_attribute03' => 'nullable|string|max:255',
            'employee_attribute04' => 'nullable|string|max:255',
            'employee_attribute05' => 'nullable|string|max:255',
            'company_id' => 'required',
        ]);
    
        // Proses penyimpanan data registrasi anggota ke dalam database
        $validatedData['company_id'] = $request->company_id;
        EmployeeInformation::create($validatedData);
    
        // Setelah data disimpan, redirect pengguna ke halaman dashboard atau ke halaman yang sesuai
        return redirect()->route('member-registration')->with('success', 'Member registered successfully!');
    }
    

    public function edit($id)
    {
        // Temukan data anggota berdasarkan ID
        $member = EmployeeInformation::findOrFail($id);

        // Tampilkan halaman edit dengan data anggota yang ditemukan
        return view('edit-member', compact('member'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form edit
        $validatedData = $request->validate([
            // Aturan validasi untuk setiap field formulir
            'full_name' => 'required|string|max:255',
            'kana_name' => 'nullable|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:employee_information,email_address,'.$id,
            'contact_phone_number' => 'nullable|string|max:20',
            'employee_code' => 'required|string|max:50|unique:employee_information,employee_code,'.$id,
            'sex' => 'nullable|string|max:10',
            'date_of_birth' => 'nullable|date',
            'date_of_joining' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'encrypted_password' => 'required|string|max:255',
            'account_status' => 'required|string|max:20',
            'password_expiration_date' => 'nullable|date',
            'number_of_incorrect_passwords' => 'required|integer',
            'account_lock_date_time' => 'nullable|date',
            'employee_attribute01' => 'nullable|string|max:255',
            'employee_attribute02' => 'nullable|string|max:255',
            'employee_attribute03' => 'nullable|string|max:255',
            'employee_attribute04' => 'nullable|string|max:255',
            'employee_attribute05' => 'nullable|string|max:255',
            'company_id' => 'required',
        ]);

        // Temukan data anggota yang akan diperbarui berdasarkan ID
        
        $member = EmployeeInformation::findOrFail($id);
        
        $member->update($validatedData);
        // Update data anggota
        $member->update([
            'fullname' => $request->full_name,
            'kananame' => $request->kana_name,
            'email_address' => $request->email_address,
            'contact_phonenumber' => $request->contact_phone_number,
            'employee_code' => $request->employee_code,
            'sex' => $request->sex,
            'dateofbirth' => $request->date_of_birth,
            'dateofjoining' => $request->date_of_joining,
            'retirementdate' => $request->retirement_date,
            'remarks' => $request->remarks,
            'encrypted_password' => $request->encrypted_password,
            'account_status' => $request->account_status,
            'password_expiration' => $request->password_expiration_date,
            'numberofincorrect_passwords' => $request->number_of_incorrect_passwords,
            'account_lock_datetime' => $request->account_lock_date_time,
            'employee_attribute01' => $request->employee_attribute01,
            'employee_attribute02' => $request->employee_attribute02,
            'employee_attribute03' => $request->employee_attribute03,
            'employee_attribute04' => $request->employee_attribute04,
            'employee_attribute05' => $request->employee_attribute05,
        ]);

        // Setelah data diperbarui, redirect pengguna ke halaman dashboard atau ke halaman yang sesuai
        return redirect()->route('member-registration')->with('success', 'Member updated successfully!');
    }


    public function destroy($id)
    {
        // Temukan data anggota yang akan dihapus berdasarkan ID
        $member = EmployeeInformation::findOrFail($id);
    
        // Hapus data anggota
        $member->delete();
    
        // Setelah data dihapus, redirect pengguna ke halaman dashboard atau ke halaman yang sesuai
        return redirect()->route('dashboard')->with('success', 'Member deleted successfully!');
    }
}
