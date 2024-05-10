<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberRegistrationController extends Controller
{
    /**
     * Menampilkan halaman registrasi anggota.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Mengambil informasi perusahaan untuk ditampilkan pada halaman registrasi
        $companies = DB::table('CompanyInformation')->get();

        // Mengambil informasi afiliasi untuk ditampilkan pada halaman registrasi
        $affiliations = DB::table('AffiliationInformation')->get();

        // Mengambil informasi pekerjaan untuk ditampilkan pada halaman registrasi
        $jobs = DB::table('JobInformation')->get();

        return view('member-registration', compact('companies', 'affiliations', 'jobs'));
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
            'FullName' => 'required|string|max:255',
            'KanaName' => 'nullable|string|max:255',
            'EmailAddress' => 'required|string|email|max:255|unique:employeeinformation',
            'ContactPhoneNumber' => 'nullable|string|max:20',
            'EmployeeCode' => 'required|string|max:50|unique:employeeinformation',
            'Sex' => 'nullable|string|max:10',
            'DateOfBirth' => 'nullable|date',
            'DateOfJoining' => 'nullable|date',
            'RetirementDate' => 'nullable|date',
            'Remarks' => 'nullable|string|max:255',
            'EncryptedPassword' => 'required|string|max:255',
            'AccountStatus' => 'required|string|max:20',
            'PasswordExpiration' => 'nullable|date',
            'NumberOfIncorrectPasswords' => 'required|integer',
            'AccountLockDateTime' => 'nullable|date',
            'EmployeeAttribute01' => 'nullable|string|max:255',
            'EmployeeAttribute02' => 'nullable|string|max:255',
            'EmployeeAttribute03' => 'nullable|string|max:255',
            'EmployeeAttribute04' => 'nullable|string|max:255',
            'EmployeeAttribute05' => 'nullable|string|max:255',
        ]);

        // Proses penyimpanan data registrasi anggota ke dalam database
        DB::table('employeeinformation')->insert([
            'FullName' => $request->FullName,
            'KanaName' => $request->KanaName,
            'EmailAddress' => $request->EmailAddress,
            'ContactPhoneNumber' => $request->ContactPhoneNumber,
            'EmployeeCode' => $request->EmployeeCode,
            'Sex' => $request->Sex,
            'DateOfBirth' => $request->DateOfBirth,
            'DateOfJoining' => $request->DateOfJoining,
            'RetirementDate' => $request->RetirementDate,
            'Remarks' => $request->Remarks,
            'EncryptedPassword' => $request->EncryptedPassword,
            'AccountStatus' => $request->AccountStatus,
            'PasswordExpiration' => $request->PasswordExpiration,
            'NumberOfIncorrectPasswords' => $request->NumberOfIncorrectPasswords,
            'AccountLockDateTime' => $request->AccountLockDateTime,
            'EmployeeAttribute01' => $request->EmployeeAttribute01,
            'EmployeeAttribute02' => $request->EmployeeAttribute02,
            'EmployeeAttribute03' => $request->EmployeeAttribute03,
            'EmployeeAttribute04' => $request->EmployeeAttribute04,
            'EmployeeAttribute05' => $request->EmployeeAttribute05,
        ]);

        // Setelah data disimpan, redirect pengguna ke halaman dashboard atau ke halaman yang sesuai
        return redirect()->route('dashboard')->with('success', 'Member registered successfully!');
    }
}
