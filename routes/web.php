<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/



# Log in

Route::view('/','hospital/login');

Route::post('/admin/login_users','App\Http\Controllers\login\login@login_users');




# Log out.

Route::get('/logout', function () {
    session()->forget('REC_SESSION_ID');
    session()->forget('DOC_SESSION_ID');
    session()->forget('ACC_SESSION_ID');
    session()->forget('OTO_SESSION_ID');
    return redirect('/');
});












# Reception [CONTROLLER::add_patient.php, invoice.php], [MIDDLEWARE::ReceptionistLoginAuth.php].

Route::group(['middleware'=>['receptionAuth']],function() {

    ##############################################################################################################################################
    # Patient Registration.  [C::add_patient.php]
    ##############################################################################################################################################

    # Going to home with home set-up
    # Redirecting to [FUNCTION-NO::01]---in-controller.
    Route::get('/reception/home/','App\Http\Controllers\reception\add_patient@set_up_home');

    # [VIEW-NO::01]
    # Going to home without home set-up
    # Returning to hospital/reception/home.blade.php---in-resources/views/.
    Route::view('/reception/home/setup/none','hospital/reception/home');

    # Going to doctor selection panel after collecting basic patient info.
    # Redirecting to [FUNCTION-NO::02]---in-controller.
    Route::post('/reception/submit_basic_patient_info','App\Http\Controllers\reception\add_patient@submit_basic_patient_info');

    # Searching old patient.
    # Redirecting to [FUNCTION-NO::03]---in-controller.
    Route::post('/reception/find_old_patient/by_search','App\Http\Controllers\reception\add_patient@search_old_patient_from_log');

    # Parsing old patient data fond by cell.
    # Redirecting to [FUNCTION-NO::03.5]---in-controller.
    Route::get('/reception/parse/old/patient/data/{P_ID}','App\Http\Controllers\reception\add_patient@parse_old_patient_data');

    # Doctor selection page.
    # Redirecting to [FUNCTION-NO::04]---in-controller.
    Route::get('/reception/doctor_selection','App\Http\Controllers\reception\add_patient@show_all_doctor');

    # Doctor selection page department side-bar action buttons.
    # Redirecting to [FUNCTION-NO::05]---in-controller.
    Route::get('/reception/doctor_selection/by_department/{department}','App\Http\Controllers\reception\add_patient@show_doctor_by_department');

    # Doctor selection page search-bar action button.
    # Redirecting to [FUNCTION-NO::06]---in-controller.
    Route::post('/reception/doctor_selection/by_search','App\Http\Controllers\reception\add_patient@search_doctor');
    
    # After selecting doctor.
    # Redirecting to [FUNCTION-NO::07]---in-controller.
    Route::post('/reception/submit_doctor_selection','App\Http\Controllers\reception\add_patient@submit_doctor_selection');

    # Showing time table based on selected doctor.
    # Redirecting to [FUNCTION-NO::08]---in-controller.
    Route::get('/reception/time_selection','App\Http\Controllers\reception\add_patient@show_available_time');

    # Selecting time.
    # Redirecting to [FUNCTION-NO::09]---in-controller.
    Route::get('/reception/set_time/{d_s_ai_id}','App\Http\Controllers\reception\add_patient@set_time');

    # Changing date.
    # Redirecting to [FUNCTION-NO::10]---in-controller.
    Route::post('reception/change_date','App\Http\Controllers\reception\add_patient@change_date');

    # Cancelling appointment.
    # Redirecting to [FUNCTION-NO::11]---in-controller.
    Route::get('/reception/cancel_appointment','App\Http\Controllers\reception\add_patient@cancel_appointment');

    # Patient data entry in table patients & patient_logs, data update in doctor_schedules table */
    # Redirecting to [FUNCTION-NO::12]---in-controller.
    Route::post('/reception/patient_data_entry_for_doctor_appointment','App\Http\Controllers\reception\add_patient@patient_data_entry_for_doctor_appointment');

    # Adding to basic patient info.
    Route::get('/reception/add_more_info',function(){

        return view('hospital/reception/admission');

    });

    # Going to doctor selection panel after collecting admit patient info.
    # Redirecting to [FUNCTION-NO::14]---in-controller.
    Route::post('/reception/submit_admit_patient_info','App\Http\Controllers\reception\add_patient@submit_admit_patient_info');

    # Bed selection page - male.
    # Redirecting to [FUNCTION-NO::15]---in-controller.
    Route::get('/reception/ward/male','App\Http\Controllers\reception\add_patient@show_wards_male');

    # Bed selection page - female.
    # Redirecting to [FUNCTION-NO::16]---in-controller.
    Route::get('/reception/ward/female','App\Http\Controllers\reception\add_patient@show_wards_female');

    # Bed selection page - child.
    # Redirecting to [FUNCTION-NO::17]---in-controller.
    Route::get('/reception/ward/child','App\Http\Controllers\reception\add_patient@show_wards_child');

    # Bed selection page - cabin.
    # Redirecting to [FUNCTION-NO::18]---in-controller.
    Route::get('/reception/cabin','App\Http\Controllers\reception\add_patient@show_cabin');

    # Bed confirmation.
    # Redirecting to [FUNCTION-NO::19]---in-controller.
    Route::get('/reception/bed/confirmation/{b_id}','App\Http\Controllers\reception\add_patient@confirm_bed');

    # No beds selected.
    # Redirecting to [FUNCTION-NO::19.5]---in-controller.
    Route::get('/reception/ward/cabin/none','App\Http\Controllers\reception\add_patient@local_patient');

    # Payment input form browsing.
    Route::get('/reception/admission/payment',function(){

        return view('hospital/reception/admission_payment');

    });

    # Bed reselection.
    # Redirecting to [FUNCTION-NO::20]---in-controller.
    Route::get('/reception/bed/reselect','App\Http\Controllers\reception\add_patient@reselect_bed');

    # Cancel admission before bed selection.
    # Redirecting to [FUNCTION-NO::21]---in-controller.
    Route::get('/reception/cancel/admission','App\Http\Controllers\reception\add_patient@cancel_admission_before_bed_selection');

    # Cancel admission after bed selection.
    # Redirecting to [FUNCTION-NO::22]---in-controller.
    Route::get('/reception/cancel/admission/after/bed','App\Http\Controllers\reception\add_patient@cancel_admission_after_bed_selection');

    # Patient data entry in table patients & admission_logs.
    # Redirecting to [FUNCTION-NO::12]---in-controller.
    Route::post('/reception/patient_data_entry_for_admission','App\Http\Controllers\reception\add_patient@patient_data_entry_for_admission');

    ##############################################################################################################################################
    # All Patients List.  [C::add_patient.php]
    ##############################################################################################################################################

    # Reading data in Patient list page.
    # Redirecting to [FUNCTION-NO::13]---in-controller.
    Route::get('/reception/patient_list/','App\Http\Controllers\reception\add_patient@show_list');

    ##############################################################################################################################################
    # Invoice.  [C::invoice.php]
    ##############################################################################################################################################

    # Reading data in Invoice generator [appointment] page.
    # Redirecting to [FUNCTION-NO::01]---in-controller.
    Route::get('/reception/invoice_list/appointment/','App\Http\Controllers\generate\invoice@invoice_list_appointment');

    # Reading data in Invoice generator [admission] page.
    # Redirecting to [FUNCTION-NO::02]---in-controller.
    Route::get('/reception/invoice_list/admission/','App\Http\Controllers\generate\invoice@invoice_list_admission');

    # Searching data in Invoice generator [appointment] page.
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::post('/reception/find_patient/by_search/invoice/appointment/','App\Http\Controllers\generate\invoice@invoice_search_appointment');

    # Generate invoice. [appointment]
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::get('/reception/collect/appointment/invoice/data/{p_l_ai_id}', 'App\Http\Controllers\generate\invoice@collect_appointment_invoice_data');

    # Generate invoice. [admission]
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::get('/reception/collect/admission/invoice/data/{a_l_ai_id}', 'App\Http\Controllers\generate\invoice@collect_admission_invoice_data');

    Route::get('/reception/generate/appointment/invoice/',function(){
        
        $pdf = PDF::loadView('hospital.invoice.appointment');

        $file_name = 'ID: '.Session::get('pId').'.pdf';

        $pdf->setOption('page-size','a5');
        $pdf->setOption('orientation','portrait');

        return $pdf->stream($file_name);

        return view('hospital/invoice/appointment');

    });

    Route::get('/reception/generate/admit/invoice/',function(){
        
        $pdf = PDF::loadView('hospital.invoice.admission');

        $file_name = 'ID: '.Session::get('pId').'.pdf';

        $pdf->setOption('page-size','a5');
        $pdf->setOption('orientation','portrait');

        return $pdf->stream($file_name);

        return view('hospital/invoice/admission');

    });















});






# Doctor [CONTROLLER::profile.php], [MIDDLEWARE::DoctorLoginAuth.php].
Route::group(['middleware'=>['doctorAuth']],function() {

    ##############################################################################################################################################
    # Doctor Profile.  [C::profile.php]
    ##############################################################################################################################################

    # Going to home with home set-up.
    # Redirecting to [FUNCTION-NO::01]---in-controller.
    Route::get('/doctor/home/','App\Http\Controllers\doctor\profile@set_up_home');

    ##############################################################################################################################################
    # Patient Status Check and Update [treated/untreated].  [C::profile.php]
    ##############################################################################################################################################

    # Showing the patients that the doctor has treated today.
    # Redirecting to [FUNCTION-NO::02]---in-controller.
    Route::get('/doctor/patients/','App\Http\Controllers\doctor\profile@show_treated_patients');

    # Search patient.
    # Redirecting to [FUNCTION-NO::03]---in-controller.
    Route::post('/doctor/search_patient/','App\Http\Controllers\doctor\profile@search_patient');

    # Search patient.
    # Redirecting to [FUNCTION-NO::04]---in-controller.
    Route::post('/doctor/set_patient_as_treated/','App\Http\Controllers\doctor\profile@set_patient_as_treated');

    ##############################################################################################################################################
    # Doctor Schedule.  [C::profile.php]
    ##############################################################################################################################################

    # Showing the doctors schedule.
    # Redirecting to [FUNCTION-NO::05]---in-controller.
    Route::get('/doctor/schedule/','App\Http\Controllers\doctor\profile@show_schedule');

    # Adding shifts.
    # Redirecting to [FUNCTION-NO::06]---in-controller.
    Route::post('/doctor/add_shift/','App\Http\Controllers\doctor\profile@add_shift');

    # Change to not available.
    # Redirecting to [FUNCTION-NO::07]---in-controller.
    Route::get('/doctor/make_n_a/{ai_id}/{day}','App\Http\Controllers\doctor\profile@not_available');

    # Change to available.
    # Redirecting to [FUNCTION-NO::08]---in-controller.
    Route::get('/doctor/make_a/{ai_id}/{day}','App\Http\Controllers\doctor\profile@available');

    # Reschedule patent.
    # Redirecting to [FUNCTION-NO::09]---in-controller.
    Route::get('/doctor/reschedule/','App\Http\Controllers\doctor\profile@reschedule');

    # Deleting shift.
    # Redirecting to [FUNCTION-NO::10]---in-controller.
    Route::get('/doctor/delete_shift/{ai_id}','App\Http\Controllers\doctor\profile@delete_shift');

    # Adding patient cap.
    # Redirecting to [FUNCTION-NO::11]---in-controller.
    Route::post('/doctor/set_patient_cap/','App\Http\Controllers\doctor\profile@patient_cap');

    ##############################################################################################################################################
    # Doctor Log.  [C::profile.php]
    ##############################################################################################################################################

    # Showing the doctors log.
    # Redirecting to [FUNCTION-NO::12]---in-controller.
    Route::get('/doctor/log/','App\Http\Controllers\doctor\profile@show_logs');

    # Searching the doctors log.
    # Redirecting to [FUNCTION-NO::13]---in-controller.
    Route::post('/doctor/search_based_on_date/','App\Http\Controllers\doctor\profile@search_logs');

    ##############################################################################################################################################
    # Doctor Edit Profile.  [C::profile.php]
    ##############################################################################################################################################
    
    # Going to edit_profile view.
    # Redirecting to hospital/doctor/edit_profile---in-resources/views/.
    Route::view('/doctor/edit_profile/','hospital/doctor/edit_profile');

    # Update profile.
    # Redirecting to [FUNCTION-NO::14]---in-controller.
    Route::post('/doctor/save_edit/','App\Http\Controllers\doctor\profile@edit_profile');



});











# Accounts [CONTROLLER::accounts.php], [MIDDLEWARE::AccountantLoginAuth.php].
Route::group(['middleware'=>['accountantAuth']],function() {

    ##############################################################################################################################################
    # Accountants Profile.  [C::accounts.php]
    ##############################################################################################################################################

    # Going to home with home set-up.
    # Redirecting to [FUNCTION-NO::01]---in-controller.
    Route::get('/accounts/home/','App\Http\Controllers\accountant\accounts@set_up_home');

    # setting commission limit.
    # Redirecting to [FUNCTION-NO::02]---in-controller.
    Route::post('/update/commission/','App\Http\Controllers\accountant\accounts@set_commission');

    # setting vat limit.
    # Redirecting to [FUNCTION-NO::03]---in-controller.
    Route::post('/update/vat/','App\Http\Controllers\accountant\accounts@set_vat');

    ##############################################################################################################################################
    # Doctors income.  [C::accounts.php]
    ##############################################################################################################################################

    # Going to doctors income page.
    # Redirecting to [FUNCTION-NO::0]---in-controller.
    Route::get('/accounts/doctor/income/','App\Http\Controllers\accountant\accounts@show_all_doctors');

    ##############################################################################################################################################
    # Accounts Edit Profile.  [C::accounts.php]
    ##############################################################################################################################################
    
    # Going to edit_profile view.
    # Redirecting to hospital/accounts/edit_profile---in-resources/views/.
    Route::view('/accounts/edit_profile/','hospital/accounts/edit_profile');

    # Update profile.
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::post('/accounts/save_edit/','App\Http\Controllers\accountant\accounts@edit_profile');

    # disposable.
    Route::view('/accounts/doctor/income/select/','hospital/accounts/doctor_income_details');
    Route::view('/accounts/pay/salary/','hospital/accounts/pay_salary');
    Route::view('/accounts/log/','hospital/accounts/logs');




});












# OT [CONTROLLER::ot.php, invoice.php], [MIDDLEWARE::OTLoginAuth.php].

Route::group(['middleware'=>['otAuth']],function() {

    ##############################################################################################################################################
    # Schedule CRUD.  [C::operations.php]
    ##############################################################################################################################################

    # Going to home(schedule) with home set-up
    # Redirecting to [FUNCTION-NO::01]---in-controller.
    Route::get('/ot/home/','App\Http\Controllers\ot\operations@set_up_home');

    # Going to schedule_entry view.
    # Redirecting to hospital/ot/schedule_entry---in-resources/views/.
    Route::view('/ot/schedule/entry/','hospital/ot/schedule_entry');

    # Going to ot_entry view.
    # Redirecting to hospital/ot/ot_entry---in-resources/views/.
    Route::view('/ot/new/entry/','hospital/ot/ot_entry');

    # Going to invoice view.
    # Redirecting to hospital/ot/invoice---in-resources/views/.
    Route::view('/ot/invoice/','hospital/ot/invoice');

    # Storing new schedule data in sessions
    # Redirecting to [FUNCTION-NO::02]---in-controller.
    Route::post('/ot/surgeon/selection','App\Http\Controllers\ot\operations@store_new_schedule_data');

    # Submitting new schedule
    # Redirecting to [FUNCTION-NO::03]---in-controller.
    Route::get('/ot/submit/new/schedule','App\Http\Controllers\ot\operations@submit_new_schedule');

    # Show new schedule
    # Redirecting to [FUNCTION-NO::04]---in-controller.
    Route::get('/ot/show/all/schedule','App\Http\Controllers\ot\operations@show_schedule_data');

    # Edit schedule
    # Redirecting to [FUNCTION-NO::05]---in-controller.
    Route::post('/ot/edit/schedule','App\Http\Controllers\ot\operations@edit_schedule_data');

    # Delete schedule
    # Redirecting to [FUNCTION-NO::06]---in-controller.
    Route::get('/ot/edit/schedule/{ai_id}','App\Http\Controllers\ot\operations@delete_schedule_data');

    ##############################################################################################################################################
    # New OT Entry After Operation.  [C::operations.php]
    ##############################################################################################################################################

    # Show admission list
    # Redirecting to [FUNCTION-NO::07]---in-controller.
    Route::get('/ot/admission/list/','App\Http\Controllers\ot\operations@show_admission_list');

    # Select entry
    # Redirecting to [FUNCTION-NO::08]---in-controller.
    Route::post('/ot/select/entry','App\Http\Controllers\ot\operations@select_entry');

    # Select entry
    # Redirecting to [FUNCTION-NO::09]---in-controller.
    Route::post('/ot/submit/entry','App\Http\Controllers\ot\operations@submit_entry');

    # Going to invoice view.
    # Redirecting to hospital/ot/surgeon_fee---in-resources/views/.
    Route::view('/ot/set/fees','hospital/ot/fee_input');

    # Surgeon fee entry
    # Redirecting to [FUNCTION-NO::10]---in-controller.
    Route::post('/ot/surgeon/fee/entry','App\Http\Controllers\ot\operations@surgeon_fee_entry');

    # Shows all entry data
    # Redirecting to [FUNCTION-NO::11]---in-controller.
    Route::get('/ot/new/entry/all/data','App\Http\Controllers\ot\operations@show_all_entry');

    # Shows all anesthesiologist
    # Redirecting to [FUNCTION-NO::12]---in-controller.
    Route::get('/ot/show/anesthesiologist/list','App\Http\Controllers\ot\operations@show_all_anesthesiologist');

    # Selects anesthesiologist
    # Redirecting to [FUNCTION-NO::13]---in-controller.
    Route::get('/ot/select/anesthesiologist/{d_id}','App\Http\Controllers\ot\operations@select_anesthesiologist');

    # Anesthesiologist fee entry
    # Redirecting to [FUNCTION-NO::14]---in-controller.
    Route::post('/ot/anesthesiologist/fee/entry','App\Http\Controllers\ot\operations@anesthesiologist_fee_entry');

    # Shows all nurse
    # Redirecting to [FUNCTION-NO::15]---in-controller.
    Route::get('/ot/show/nurse/list','App\Http\Controllers\ot\operations@show_all_nurse');

    # Selects nurse
    # Redirecting to [FUNCTION-NO::16]---in-controller.
    Route::get('/ot/select/nurse/{n_id}','App\Http\Controllers\ot\operations@select_nurse');

    # Nurse fee entry
    # Redirecting to [FUNCTION-NO::17]---in-controller.
    Route::post('/ot/nurse/fee/entry','App\Http\Controllers\ot\operations@nurse_fee_entry');

    # Assistant data collection
    # Redirecting to [FUNCTION-NO::18]---in-controller.
    Route::get('/ot/assistant/data/collection','App\Http\Controllers\ot\operations@assistant_data_collection');

    # Assistant data entry
    # Redirecting to [FUNCTION-NO::19]---in-controller.
    Route::post('/ot/assistant/data/entry','App\Http\Controllers\ot\operations@assistant_data_entry');

    # Delete surgeon entry
    # Redirecting to [FUNCTION-NO::20]---in-controller.
    Route::get('/remove/surgeon/{ai_id}','App\Http\Controllers\ot\operations@delete_surgeon_entry');

    # Delete anesthesiologist entry
    # Redirecting to [FUNCTION-NO::21]---in-controller.
    Route::get('/remove/anesthesiologist/{ai_id}','App\Http\Controllers\ot\operations@delete_anesthesiologist_entry');

    # Delete nurse entry
    # Redirecting to [FUNCTION-NO::22]---in-controller.
    Route::get('/remove/nurse/{ai_id}','App\Http\Controllers\ot\operations@delete_nurse_entry');

    # Delete assistant entry
    # Redirecting to [FUNCTION-NO::23]---in-controller.
    Route::get('/remove/assistant/{ai_id}','App\Http\Controllers\ot\operations@delete_assistant_entry');

    # Delete assistant entry
    # Redirecting to [FUNCTION-NO::24]---in-controller.
    Route::get('/ot/new/entry/cancel','App\Http\Controllers\ot\operations@cancel_new_entry');

    # Delete assistant entry
    # Redirecting to [FUNCTION-NO::25]---in-controller.
    Route::post('/ot/entry/list/submit','App\Http\Controllers\ot\operations@entry_list_submission');

    ##############################################################################################################################################
    # Doctor List Browsing.  [C::add_patient.php]
    ##############################################################################################################################################

    # Doctor selection page.
    # Redirecting to [FUNCTION-NO::04]---in-controller.
    Route::get('/ot/doctor_selection','App\Http\Controllers\reception\add_patient@show_all_doctor');

    # Doctor selection page department side-bar action buttons.
    # Redirecting to [FUNCTION-NO::05]---in-controller.
    Route::get('/ot/doctor_selection/by_department/{department}','App\Http\Controllers\reception\add_patient@show_doctor_by_department');

    # Doctor selection page search-bar action button.
    # Redirecting to [FUNCTION-NO::06]---in-controller.
    Route::post('/ot/doctor_selection/by_search','App\Http\Controllers\reception\add_patient@search_doctor');
    
    # After selecting doctor.
    # Redirecting to [FUNCTION-NO::07]---in-controller.
    Route::post('/ot/submit_doctor_selection','App\Http\Controllers\reception\add_patient@submit_doctor_selection');

    ##############################################################################################################################################
    # Invoice.  [C::invoice.php]
    ##############################################################################################################################################

    # Reading data in Invoice generator [ot] page.
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::get('/ot/invoice/generate/list/','App\Http\Controllers\generate\invoice@invoice_list_ot');

    # Searching data in Invoice generator [ot] page.
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::post('/ot/find_patient/by_search/invoice/ot/bill/','App\Http\Controllers\generate\invoice@invoice_search_ot_bill');

    # Generate invoice. [ot]
    # Redirecting to [FUNCTION-NO::]---in-controller.
    Route::get('/ot/collect/ot/bill/invoice/data/{o_id}', 'App\Http\Controllers\generate\invoice@collect_ot_bill_invoice_data');

    Route::get('/ot/generate/bill/invoice/',function(){

        $o_id = Session::get('oId');
        
        $chosen_surgeons=DB::table('surgeon_logs')
            ->where('O_ID', $o_id)
            ->orderBy('AI_ID','asc')
            ->get();

        $chosen_anesthesiologist=DB::table('anesthesiologist_logs')
            ->where('O_ID', $o_id)
            ->orderBy('AI_ID','asc')
            ->get();

        $chosen_nurses=DB::table('ot_nurses_logs')
            ->where('O_ID', $o_id)
            ->orderBy('AI_ID','asc')
            ->get();

        $chosen_assistant=DB::table('ot_assistant_logs')
            ->where('O_ID', $o_id)
            ->orderBy('AI_ID','asc')
            ->get();
        
        $pdf = PDF::loadView('hospital.invoice.ot_bill', compact('chosen_surgeons','chosen_anesthesiologist','chosen_nurses','chosen_assistant'));

        $file_name = 'ID: '.Session::get('pId').'.pdf';

        $pdf->setOption('page-size','a4');
        $pdf->setOption('orientation','portrait');

        return $pdf->stream($file_name);

        # Returning to the view below.
        return view('hospital/invoice/ot_bill', compact('chosen_surgeons','chosen_anesthesiologist','chosen_nurses','chosen_assistant'));

    });

});