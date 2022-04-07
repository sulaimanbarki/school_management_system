<?php

use App\Http\Controllers\AcademicsessionsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPages;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewAdmission;
use App\Http\Controllers\AddClass_Section;
use App\Http\Controllers\AddsectionController;
use App\Http\Controllers\AddStock;
use App\Http\Controllers\AdvanceSalaryController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\NewAdmissionController;
use App\Http\Controllers\Campus;
use App\Http\Controllers\ClassWisePersonalDevelopmentController;
use App\Http\Controllers\ClassWiseTeacherController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyWalletController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExaminationReports;
use App\Http\Controllers\FeeGenerations;
use App\Http\Controllers\FeeGenerationsCalculate;
use App\Http\Controllers\FeeGenerationsController;
use App\Http\Controllers\FeeReports;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\FeesSlip;
use App\Http\Controllers\ReportStudents;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\SMSRemainder;
use App\Http\Controllers\NetSalarySheet;
use App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\StudentMarksController;
use App\Http\Controllers\StudentRegistrationsController;
use App\Http\Controllers\StudentWiseFeeCriteriaController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\SubjectWiseMarks;
use App\Models\addsection;
use App\Http\Controllers\ExamReports;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseHeadController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\NetSalaryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ScaleController;
use App\Http\Controllers\SchooleavingcirtificateController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffProfile;
use App\Http\Controllers\StaffSalaryDetailsController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentpersonaldevelopmentController;
use App\Http\Controllers\StudentPromotion;
use App\Http\Controllers\StudentsCommentController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserWalletController;
use App\Models\MainCategory;
use App\Models\schooleavingcirtificate;
use Illuminate\Support\Facades\Artisan;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/admin/login');
Route::redirect('/login', '/admin/login');
Route::group(['prefix' => 'admin', 'middleware' => ['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::get('/backupdatabase', function () {
    $exitCode = Artisan::call('db:backup');
});


// Route::middleware(['auth:admin', 'verified'])->get('/admin/dashboard', function () {
//     //    dd(Auth::id());
//     return view('admin.index');
// })->name('dashboard');
//
// za da poe kma aawal gura da landi che sumaa routes da kna da admin da
// da without login khom access kegeege gura

Route::middleware(['RolesAndPages', 'auth:admin'])->prefix('admin')->group(function () {
    Route::get('/Pages', [AdminPages::class, 'Index'])->name('adminbackend.pages.page');
    Route::get('/PagesRoleWise', [AdminPages::class, 'PagesRoleWise'])->name('adminbackend.pages.PagesRoleWise');
    Route::get('/AddCampus', [Campus::class, 'Index'])->name('adminbackend.addCampus.page');
    Route::get('/AddRole', [RoleController::class, 'Index'])->name('adminbackend.AddRole.page');
    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('Admin.logout');
    Route::get('/AddEmployee', [EmployeeController::class, 'Index'])->name('adminbackend.AddEmployee.page');
    Route::get('/addClass', [AddClass_Section::class, 'Index'])->name('adminbackend.addClass.page');
    Route::get('/NewRegistration', [NewAdmission::class, 'LoadRegistration'])->name('adminbackend.NewRegistration.page');
    Route::get('/NewAdmission', [NewAdmission::class, 'Loadpage'])->name('adminbackend.NewAdmission.page');
    Route::get('/AddFees', [FeesController::class, 'Index'])->name('adminbackend.AddFees.page');
    Route::get('/ClassWiseFeeCriterial', [FeesController::class, 'LoadClassWiseCriterial'])->name('adminbackend.ClassWiseFeeCriterial.page');
    Route::get('/AddScholarships', [ScholarshipController::class, 'Index'])->name('adminbackend.AddScholarships.page');
    Route::get('/AddStudentWiseFeeCriteria', [StudentWiseFeeCriteriaController::class, 'Index'])->name('adminbackend.AddStudentWiseFeeCriteria.page');
    Route::get('/FeeGenerations', [FeeGenerationsController::class, 'Index'])->name('adminbackend.FeeGenerations.page');
    Route::get('/FeeGenerationStaff', [NetSalaryController::class, 'Index'])->name('adminbackend.FeeGenerationStaff.page');
    Route::get('/NetSalarySheet', [NetSalarySheet::class, 'Index'])->name('adminbackend.NetSalarySheet.page');
    Route::get('/EditFeeSlip', [FeeGenerationsController::class, 'LoadEditFeePage'])->name('adminbackend.EditFeeSlip.page');
    Route::get('/FeesSlip', [FeesSlip::class, 'Index'])->name('adminbackend.FeesSlip.page');
    Route::get('/ReportStudents', [ReportStudents::class, 'index'])->name('adminbackend.ReportStudents.page');
    Route::get('/FeeReports', [FeeReports::class, 'index'])->name('adminbackend.FeeReports.page');
    Route::get('/ExaminationReports', [ExaminationReports::class, 'index'])->name('adminbackend.ExaminationReports.page');
    Route::get('/ExpenseAndIncomeReports', [ExpenseReportController::class, 'index'])->name('adminbackend.ExpenseAndIncomeReports.page');
    Route::get('/InventoryReports', [AddStock::class, 'InventoryReports'])->name('adminbackend.InventoryReports.page');
    Route::get('/SMSRemainder', [SMSRemainder::class, 'index'])->name('adminbackend.SMSRemainder.page');
    Route::get('/AddSubjects', [SubjectsController::class, 'index'])->name('adminbackend.AddSubjects.page');
    Route::get('/SubjectWiseMarks', [SubjectWiseMarks::class, 'index'])->name('adminbackend.SubjectWiseMarks.page');
    Route::get('/PersonalDevelopment', [StudentpersonaldevelopmentController::class, 'index'])->name('adminbackend.PersonalDevelopment.page');
    Route::get('/ClassWisePersonalDevelopment', [ClassWisePersonalDevelopmentController::class, 'index'])->name('adminbackend.ClassWisePersonalDevelopment.page');
    Route::get('/StaffwiseFeesCriteria', [StaffSalaryDetailsController::class, 'index'])->name('adminbackend.StaffwiseFeesCriteria.page');
    Route::get('/TimeTable', [TimeTableController::class, 'TimeTable'])->name('adminbackend.TimeTable.page');
    // profile
    Route::get('/StudentProfile', [StudentInfoController::class, 'StudentProfile'])->name('adminbackend.StudentProfile.page');
    Route::get('/StudentPromotion', [StudentPromotion::class, 'index'])->name('admin.StudentPromotion');
    // staff profile
    Route::get('/StaffProfile', [StaffProfile::class, 'index'])->name('adminbackend.StaffProfile');
    // print slips
    Route::get('/Expenses', [ExpenseController::class, 'Expenses'])->name('adminbackend.Expenses.page');
    Route::get('/Accounts', [AccountController::class, 'Accounts'])->name('adminbackend.Accounts.page');
    Route::get('/Locations', [LocationController::class, 'Locations'])->name('adminbackend.Locations.page');
    Route::get('/AddCampus', [Campus::class, 'Index'])->name('adminbackend.addCampus.page');
    Route::get('/StudentsAttendance', [StudentAttendanceController::class, 'Attendance'])->name('adminbackend.StudentsAttendance.page');
    Route::get('/CompaniesPage', [CompanyController::class, 'Companies'])->name('adminbackend.CompaniesPage.page');
    Route::get('/ItemsPage', [ItemController::class, 'ItemsPage'])->name('adminbackend.ItemsPage.page');
    Route::get('/AddStock', [AddStock::class, 'AddStock'])->name('adminbackend.Inventory.AddStock');
    Route::get('/StockStatistics', [AddStock::class, 'StockStatistics'])->name('adminbackend.Inventory.StockStatistics');
    Route::get('/CounterSale', [AddStock::class, 'CounterSale'])->name('adminbackend.Inventory.CounterSale');
    Route::get('/payments', [AddStock::class, 'Payments'])->name('adminbackend.payments.CounterSale');
});

// 'prefix' => 'admin','middleware' => ['auth:admin']
// Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'RolesAndPages']], function (){
//     Route::get('/Pages', [AdminPages::class, 'Index'])->name('adminbackend.pages.page');
//     Route::get('/PagesRoleWise', [AdminPages::class, 'PagesRoleWise'])->name('adminbackend.pages.PagesRoleWise');
//     Route::get('/AddCampus', [Campus::class, 'Index'])->name('adminbackend.addCampus.page');
//     Route::get('/AddRole', [RoleController::class, 'Index'])->name('adminbackend.AddRole.page');
//     Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('Admin.logout');
//     Route::get('/AddEmployee', [EmployeeController::class, 'Index'])->name('adminbackend.AddEmployee.page');
//     Route::get('/addClass', [AddClass_Section::class, 'Index'])->name('adminbackend.addClass.page');
//     Route::get('/NewRegistration', [NewAdmission::class, 'LoadRegistration'])->name('adminbackend.NewRegistration.page');
//     Route::get('/NewAdmission', [NewAdmission::class, 'Loadpage'])->name('adminbackend.NewAdmission.page');
//     Route::get('/NewAdmissionEdit/{userid}', [NewAdmission::class, 'LoadpageEdit']);
//     Route::get('/AddFees', [FeesController::class, 'Index'])->name('adminbackend.AddFees.page');
//     Route::get('/ClassWiseFeeCriterial', [FeesController::class, 'LoadClassWiseCriterial'])->name('adminbackend.ClassWiseFeeCriterial.page');
//     Route::get('/AddScholarships', [ScholarshipController::class, 'Index'])->name('adminbackend.AddScholarships.page');
//     Route::get('/AddStudentWiseFeeCriteria', [StudentWiseFeeCriteriaController::class, 'Index'])->name('adminbackend.AddStudentWiseFeeCriteria.page');
//     Route::get('/FeeGenerations', [FeeGenerationsController::class, 'Index'])->name('adminbackend.FeeGenerations.page');
//     Route::get('/FeeGenerationStaff', [NetSalaryController::class, 'Index'])->name('adminbackend.FeeGenerationStaff.page');
// 	Route::get('/NetSalarySheet', [NetSalarySheet::class, 'Index'])->name('adminbackend.NetSalarySheet.page');
//     Route::get('/EditFeeSlip', [FeeGenerationsController::class, 'LoadEditFeePage'])->name('adminbackend.EditFeeSlip.page');
//     Route::get('/FeesSlip', [FeesSlip::class, 'Index'])->name('adminbackend.FeesSlip.page');
//     Route::get('/ReportStudents', [ReportStudents::class, 'index'])->name('adminbackend.ReportStudents.page');
//     Route::get('/FeeReports', [FeeReports::class, 'index'])->name('adminbackend.FeeReports.page');
//     Route::get('/ExaminationReports', [ExaminationReports::class, 'index'])->name('adminbackend.ExaminationReports.page');
//     Route::get('/ExpenseAndIncomeReports', [ExpenseReportController::class, 'index'])->name('adminbackend.ExpenseAndIncomeReports.page');
//     Route::get('/SMSRemainder', [SMSRemainder::class, 'index'])->name('adminbackend.SMSRemainder.page');
//     Route::get('/AddSubjects', [SubjectsController::class, 'index'])->name('adminbackend.AddSubjects.page');
//     Route::get('/SubjectWiseMarks', [SubjectWiseMarks::class, 'index'])->name('adminbackend.SubjectWiseMarks.page');
//     Route::get('/PersonalDevelopment', [StudentpersonaldevelopmentController::class, 'index'])->name('adminbackend.PersonalDevelopment.page');
//     Route::get('/ClassWisePersonalDevelopment', [ClassWisePersonalDevelopmentController::class, 'index'])->name('adminbackend.ClassWisePersonalDevelopment.page');
//     Route::get('/StaffwiseFeesCriteria', [StaffSalaryDetailsController::class, 'index'])->name('adminbackend.StaffwiseFeesCriteria.page');
//     Route::get('/TimeTable', [TimeTableController::class, 'TimeTable'])->name('adminbackend.TimeTable.page');
//     // profile
//     Route::get('/StudentProfile', [StudentInfoController::class, 'StudentProfile'])->name('adminbackend.StudentProfile.page');
//     Route::get('/StudentPromotion', [StudentPromotion::class, 'index'])->name('admin.StudentPromotion');
//     // staff profile
//     Route::get('/StaffProfile', [StaffProfile::class, 'index'])->name('adminbackend.StaffProfile');
//     // print slips
//     Route::get('/Expenses', [ExpenseController::class, 'Expenses'])->name('adminbackend.Expenses.page');
//     Route::get('/Accounts', [AccountController::class, 'Accounts'])->name('adminbackend.Accounts.page');
//     Route::get('/Locations', [LocationController::class, 'Locations'])->name('adminbackend.Locations.page');
// });

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    });

    // Route::get('/Pages', [AdminPages::class, 'Index'])->name('adminbackend.pages.page');
    // Route::get('/PagesRoleWise', [AdminPages::class, 'PagesRoleWise'])->name('adminbackend.pages.PagesRoleWise');
    // Route::get('/AddCampus', [Campus::class, 'Index'])->name('adminbackend.addCampus.page');
    // Route::get('/AddRole', [RoleController::class, 'Index'])->name('adminbackend.AddRole.page');
    // Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('Admin.logout');
    // Route::get('/AddEmployee', [EmployeeController::class, 'Index'])->name('adminbackend.AddEmployee.page');
    // Route::get('/addClass', [AddClass_Section::class, 'Index'])->name('adminbackend.addClass.page');
    // Route::get('/NewRegistration', [NewAdmission::class, 'LoadRegistration'])->name('adminbackend.NewRegistration.page');
    // Route::get('/NewAdmission', [NewAdmission::class, 'Loadpage'])->name('adminbackend.NewAdmission.page');
    // Route::get('/NewAdmissionEdit/{userid}', [NewAdmission::class, 'LoadpageEdit']);
    // Route::get('/AddFees', [FeesController::class, 'Index'])->name('adminbackend.AddFees.page');
    // Route::get('/ClassWiseFeeCriterial', [FeesController::class, 'LoadClassWiseCriterial'])->name('adminbackend.ClassWiseFeeCriterial.page');
    // Route::get('/AddScholarships', [ScholarshipController::class, 'Index'])->name('adminbackend.AddScholarships.page');
    // Route::get('/AddStudentWiseFeeCriteria', [StudentWiseFeeCriteriaController::class, 'Index'])->name('adminbackend.AddStudentWiseFeeCriteria.page');
    // Route::get('/FeeGenerations', [FeeGenerationsController::class, 'Index'])->name('adminbackend.FeeGenerations.page');
    // Route::get('/FeeGenerationStaff', [NetSalaryController::class, 'Index'])->name('adminbackend.FeeGenerationStaff.page');
    // Route::get('/NetSalarySheet', [NetSalarySheet::class, 'Index'])->name('adminbackend.NetSalarySheet.page');
    // Route::get('/EditFeeSlip', [FeeGenerationsController::class, 'LoadEditFeePage'])->name('adminbackend.EditFeeSlip.page');
    // Route::get('/FeesSlip', [FeesSlip::class, 'Index'])->name('adminbackend.FeesSlip.page');
    // Route::get('/ReportStudents', [ReportStudents::class, 'index'])->name('adminbackend.ReportStudents.page');
    // Route::get('/FeeReports', [FeeReports::class, 'index'])->name('adminbackend.FeeReports.page');
    // Route::get('/ExaminationReports', [ExaminationReports::class, 'index'])->name('adminbackend.ExaminationReports.page');
    // Route::get('/ExpenseAndIncomeReports', [ExpenseReportController::class, 'index'])->name('adminbackend.ExpenseAndIncomeReports.page');
    // Route::get('/SMSRemainder', [SMSRemainder::class, 'index'])->name('adminbackend.SMSRemainder.page');
    // Route::get('/AddSubjects', [SubjectsController::class, 'index'])->name('adminbackend.AddSubjects.page');
    // Route::get('/SubjectWiseMarks', [SubjectWiseMarks::class, 'index'])->name('adminbackend.SubjectWiseMarks.page');
    // Route::get('/PersonalDevelopment', [StudentpersonaldevelopmentController::class, 'index'])->name('adminbackend.PersonalDevelopment.page');
    // Route::get('/ClassWisePersonalDevelopment', [ClassWisePersonalDevelopmentController::class, 'index'])->name('adminbackend.ClassWisePersonalDevelopment.page');
    // Route::get('/StaffwiseFeesCriteria', [StaffSalaryDetailsController::class, 'index'])->name('adminbackend.StaffwiseFeesCriteria.page');
    // Route::get('/TimeTable', [TimeTableController::class, 'TimeTable'])->name('adminbackend.TimeTable.page');
    // // profile
    // Route::get('/StudentProfile', [StudentInfoController::class, 'StudentProfile'])->name('adminbackend.StudentProfile.page');
    // Route::get('/StudentPromotion', [StudentPromotion::class, 'index'])->name('admin.StudentPromotion');
    // // staff profile
    // Route::get('/StaffProfile', [StaffProfile::class, 'index'])->name('adminbackend.StaffProfile');
    // // print slips
    // Route::get('/Expenses', [ExpenseController::class, 'Expenses'])->name('adminbackend.Expenses.page');
    // Route::get('/Accounts', [AccountController::class, 'Accounts'])->name('adminbackend.Accounts.page');
    // Route::get('/Locations', [LocationController::class, 'Locations'])->name('adminbackend.Locations.page');
    // Route::get('/AddCampus', [Campus::class, 'Index'])->name('adminbackend.addCampus.page');






    Route::post('/NetSalarySheet', [NetSalarySheet::class, 'Index2']);
    Route::get('/NewAdmissionEdit/{userid}', [NewAdmission::class, 'LoadpageEdit']);
    Route::get('/PrintSlip', [FeeGenerationsController::class, 'PrintSlip'])->name('adminbackend.PrintSlip.page');
    // student promotion
    Route::post('/RelativesData', [StudentInfoController::class, 'RelativesData'])->name('adminbackend.RelativesData');
    Route::post('/LoadStudenInfo', [StudentInfoController::class, 'LoadStudenInfo'])->name('adminbackend.LoadStudenInfo');
    Route::post('/PagesRoleWiseLoad', [AdminPages::class, 'PagesRoleWiseLoad'])->name('admin.PagesRoleWiseLoad');
    Route::post('/UpdatePagesRole', [AdminPages::class, 'UpdatePagesRole'])->name('admin.UpdatePagesRole');

    Route::post('/LoadStaffInfo', [StaffProfile::class, 'LoadStaffInfo'])->name('adminbackend.LoadStaffInfo');
    Route::post('/LoadStaffAllowances', [StaffProfile::class, 'LoadStaffAllowances'])->name('admin.LoadStaffAllowances');
    Route::post('/LoadAdvanceSalary', [StaffProfile::class, 'LoadAdvanceSalary'])->name('admin.LoadAdvanceSalary');
    Route::post('/TotalSalaryPaid', [StaffProfile::class, 'TotalSalaryPaid'])->name('admin.TotalSalaryPaid');
    Route::post('/FetchStaffSalaries', [StaffProfile::class, 'FetchStaffSalaries'])->name('admin.FetchStaffSalaries');
    Route::post('/FetchStaffDeductionsAndAllowances', [StaffProfile::class, 'FetchStaffDeductionsAndAllowances'])->name('admin.FetchStaffDeductionsAndAllowances');





    // add campus
    Route::post('/AddCampusConfigration', [Campus::class, 'store'])->name('admin.AddCampusConfigration');
    Route::post('/UpdateCampusConfigration', [Campus::class, 'update'])->name('admin.UpdateCampusConfigration');
    Route::get('/AddCampusConfigration', [Campus::class, 'show'])->name('admin.ViewCampusConfigration');

    // add class
    Route::post('/StoreClass', [AddClass_Section::class, 'store'])->name('admin.StoreClass');
    Route::post('/AddClassConfigration', [AddClass_Section::class, 'FetchClasses'])->name('admin.ViewClass');
    Route::post('/UpdateClassConfigration', [AddClass_Section::class, 'update'])->name('admin.UpdateClassConfigration');
    Route::post('/FetchClasses', [AddClass_Section::class, 'FetchClasses'])->name('admin.ViewClasss');
    Route::post('/FetchSections', [AddClass_Section::class, 'ViewSections'])->name('admin.ViewSections');
    // store busses
    Route::post('/AddBusConfigration', [AddClass_Section::class, 'storeBus'])->name('admin.AddBusConfigration');
    Route::get('/AddBusConfigration', [AddClass_Section::class, 'showBuses'])->name('admin.ViewBusesConfigration');
    Route::post('/UpdateBusConfigration', [AddClass_Section::class, 'updateBus'])->name('admin.UpdateBusConfigration');
    Route::post('/ViewBuses', [AddClass_Section::class, 'showBuses'])->name('admin.ViewBuses');

    // add section to class
    Route::post('/SectionAssign', [AddClass_Section::class, 'SectionAssign'])->name('admin.SectionAssign');

    // add section
    Route::post('/AddSectionConfigration', [AddsectionController::class, 'store'])->name('admin.AddSectionConfigration');
    Route::get('/AddSectionConfigration1', [AddsectionController::class, 'show'])->name('admin.ViewSectionConfigration');
    Route::get('/FetchSectionForClassConfigration', [AddsectionController::class, 'showSectionForClass'])->name('admin.FetchSectionForClassConfigration');
    Route::post('/UpdateSectionConfigration', [AddsectionController::class, 'update'])->name('admin.UpdateSectionConfigration');
    Route::post('/ViewClassWiseSection', [AddClass_Section::class, 'ViewClasssWiseSection'])->name('admin.ViewClasssWiseSection');
    Route::post('/DeleteClasswiseSecion', [AddClass_Section::class, 'destroy'])->name('admin.DeleteClasswiseSecion');


    // add session
    Route::post('/AddSessionConfigration', [AcademicsessionsController::class, 'store'])->name('admin.AddSessionConfigration');
    Route::get('/AddSessionConfigration', [AcademicsessionsController::class, 'show'])->name('admin.ViewSessionConfigration');
    Route::post('/UpdateSessionConfigration', [AcademicsessionsController::class, 'update'])->name('admin.UpdateSessionConfigration');

    // add roles
    Route::post('/AddRoleConfigration', [RoleController::class, 'store'])->name('admin.AddRoleConfigration');
    Route::get('/AddRoleConfigration', [RoleController::class, 'show'])->name('admin.ViewRoleConfigration');
    Route::post('/UpdateRoleConfigration', [RoleController::class, 'update'])->name('admin.UpdateRoleConfigration');

    // add employee
    Route::post('/AddEmployeeConfigration', [EmployeeController::class, 'store'])->name('admin.AddEmployeeConfigration');
    Route::get('/AddEmployeeConfigration', [EmployeeController::class, 'show'])->name('admin.ViewEmployeeConfigration');
    Route::post('/UpdateEmployeeConfigration', [EmployeeController::class, 'update'])->name('admin.UpdateEmployeeConfigration');

    // add designation
    Route::post('/AddDesignationConfigration', [DesignationController::class, 'store'])->name('admin.AddDesignationConfigration');
    Route::get('/AddDesignationConfigration', [DesignationController::class, 'show'])->name('admin.ViewDesignationConfigration');
    Route::post('/UpdateDesignationConfigration', [DesignationController::class, 'update'])->name('admin.UpdateDesignationConfigration');

    // add scales
    Route::post('/AddScale', [ScaleController::class, 'store'])->name('admin.AddScale');
    Route::get('/ViewScale', [ScaleController::class, 'show'])->name('admin.ViewScale');
    Route::post('/UpdateScale', [ScaleController::class, 'update'])->name('admin.UpdateScale');

    // add department
    Route::post('/AddDepartment', [DepartmentController::class, 'store'])->name('admin.AddDepartment');
    Route::get('/ViewDepartment', [DepartmentController::class, 'show'])->name('admin.ViewDepartment');
    Route::post('/UpdateDepartment', [DepartmentController::class, 'update'])->name('admin.UpdateDepartment');

    // add allowance
    Route::post('/AddAllowance', [AllowanceController::class, 'store'])->name('admin.AddAllowance');
    Route::post('/ViewAllowances', [AllowanceController::class, 'show'])->name('admin.ViewAllowances');
    Route::post('/UpdateAllowance', [AllowanceController::class, 'update'])->name('admin.UpdateAllowance');
    Route::post('/ChechAdvanceSalry', [AllowanceController::class, 'ChechAdvanceSalry'])->name('admin.ChechAdvanceSalry');

    // add student registration
    Route::post('/AddRegistrationConfigration', [StudentRegistrationsController::class, 'store'])->name('admin.AddRegistrationConfigration');
    Route::get('/AddRegistrationConfigration', [StudentRegistrationsController::class, 'show'])->name('admin.ViewRegistrationConfigration');
    Route::post('/UpdateRegistrationConfigration', [StudentRegistrationsController::class, 'update'])->name('admin.UpdateRegistrationConfigration');
    Route::post('/checkFormExists', [StudentRegistrationsController::class, 'showExistsStd'])->name('admin.checkFormExists');

    // Fetch Admission Number
    Route::get('/FetchAdmissionNumberConfigration', [StudentInfoController::class, 'fetchAdmissionId'])->name('admin.FetchAdmissionNumberConfigration');

    // add student admission
    Route::post('/AddAdmissionConfigration', [StudentInfoController::class, 'store'])->name('admin.AddAdmissionConfigration');
    Route::get('/AddAdmissionConfigration', [StudentInfoController::class, 'show'])->name('admin.ViewAdmissionConfigration');
    Route::post('/UpdateAdmissionConfigration', [StudentInfoController::class, 'update'])->name('admin.UpdateAdmissionConfigration');

    // add fees head
    Route::post('/AddFeesHeadConfigration', [FeesController::class, 'store'])->name('admin.AddFeesHeadConfigration');
    Route::get('/AddFeesHeadConfigration', [FeesController::class, 'show'])->name('admin.ViewFeesHeadConfigration');
    Route::post('/UpdateFeesHeadConfigration', [FeesController::class, 'update'])->name('admin.UpdateFeesHeadConfigration');
    Route::post('/UpdateStudentWiseFeeAmount', [FeesController::class, 'UpdateStudentWiseFeeAmount'])->name('admin.UpdateStudentWiseFeeAmount');

    // add class wise fee criterial
    Route::post('/ClassWiseFeeCriteria', [FeesController::class, 'storeFeesCriteria'])->name('admin.AddFeesHeadConfigrationConfigration');
    Route::get('/ClassWiseFeeCriteria', [FeesController::class, 'showFeesCriteria'])->name('admin.ViewFeesCriteriaConfigration');
    Route::post('/DeleteClassWiseFeeCriteria', [FeesController::class, 'destroyFeesCriteria'])->name('admin.DeleteClassWiseFeeCriteria');
    Route::post('/UpdateClassWiseFeeCriteria', [FeesController::class, 'UpdateClassWiseFeeCriteria'])->name('admin.UpdateClassWiseFeeCriteria');
    Route::post('/StoreFeeheadsSessionWise', [FeesController::class, 'StoreFeeheadsSessionWise'])->name('admin.StoreFeeheadsSessionWise');

    // add scholarship
    Route::post('/AddScholarshipConfigration', [ScholarshipController::class, 'store'])->name('admin.AddScholarshipConfigration');
    Route::get('/ViewScholarshpConfigration', [ScholarshipController::class, 'show'])->name('admin.ViewScholarshpConfigration');
    Route::post('/UpdateScholarshpConfigration', [ScholarshipController::class, 'update'])->name('admin.UpdateScholarshpConfigration');

    // add student wise fee criteria
    Route::post('/StoreStudentWiseFeeCriteria', [StudentWiseFeeCriteriaController::class, 'store'])->name('admin.StoreStudentWiseFeeCriteria');
    Route::get('/ViewStudentWiseFeeCriteriaConfigration', [StudentWiseFeeCriteriaController::class, 'show'])->name('admin.ViewStudentWiseFeeCriteriaConfigration');
    Route::post('/DeleteStudentWiseFeeCriteria', [StudentWiseFeeCriteriaController::class, 'destroy'])->name('admin.DeleteStudentWiseFeeCriteria');

    // add scholarshi wise subhead
    Route::post('/AddSholarshipWiseSubheads', [ScholarshipController::class, 'storeSWSH'])->name('admin.AddSholarshipWiseSubheads');
    Route::get('/ViewSholarshipWiseSubheads', [ScholarshipController::class, 'showSWSH'])->name('admin.ViewSholarshipWiseSubheads');
    Route::post('/DeleteSholarshipWiseSubheads', [ScholarshipController::class, 'destroySWSH'])->name('admin.DeleteSholarshipWiseSubheads');

    // add staff wise fees criteria
    Route::post('/StoreStaffwiseFeesCriteria', [StaffSalaryDetailsController::class, 'store'])->name('admin.StoreStaffwiseFeesCriteria');
    Route::post('/ViewStaffWiseFeeCriteria', [StaffSalaryDetailsController::class, 'show'])->name('admin.ViewStaffWiseFeeCriteria');
    Route::post('/UpdateStaffwiseFeesCriteria', [StaffSalaryDetailsController::class, 'update'])->name('admin.UpdateStaffwiseFeesCriteria');

    // fee generations
    Route::post('/ViewAllStudents', [FeeGenerationsController::class, 'showAllStudents'])->name('admin.ViewAllStudents');
    Route::post('/ViewClassWiseStudents', [FeeGenerationsController::class, 'showClassWiseStudents'])->name('admin.ViewClassWiseStudents');
    Route::post('/ViewSingleStudent', [FeeGenerationsController::class, 'showSingleStudent'])->name('admin.ViewSingleStudent');

    // staff salary generations
    Route::post('/DepartmentWiseStaff', [NetSalaryController::class, 'showDepartmentWiseStaff'])->name('admin.DepartmentWiseStaff');
    Route::post('/showDepartmentAndScaleWiseStaff', [NetSalaryController::class, 'showDepartmentAndScaleWiseStaff'])->name('admin.showDepartmentAndScaleWiseStaff');
    Route::post('/ViewSingleEmployee', [NetSalaryController::class, 'showSingleEmployee'])->name('admin.ViewSingleEmployee');
    Route::post('/GenerateSalary', [NetSalaryController::class, 'GenerateSalary'])->name('admin.GenerateSalary');

    // staff advance salary
    Route::resource('advanceSalary', AdvanceSalaryController::class);

    Route::post('/GetSectionClassWise', [FeeGenerationsController::class, 'GetSectionClassWise'])->name('admin.GetSectionClassWise');
    Route::post('/ViewStudentsClassANDsectionsWise', [FeeGenerationsController::class, 'ViewStudentsClassANDsectionsWise'])->name('admin.ViewStudentsClassANDsectionsWise');
    Route::post('/GenerateFees', [FeeGenerationsCalculate::class, 'GenerateFees'])->name('admin.GenerateFees');
    Route::get('/ViewStudentFeesDetails', [FeeGenerationsCalculate::class, 'FetchFeesDetails'])->name('admin.ViewStudentFeesDetails');
    Route::post('/EditFeeFetch', [FeeGenerationsCalculate::class, 'EditFeeFetch'])->name('admin.EditFeeFetch');
    Route::post('/UpdateFees', [FeeGenerationsCalculate::class, 'UpdateFees'])->name('admin.UpdateFees');
    Route::post('/ReverseStudentFees', [FeeGenerationsCalculate::class, 'ReverseStudentFees'])->name('admin.ReverseStudentFees');
    Route::post('/fetchUnpaidSubheads', [FeeGenerationsCalculate::class, 'fetchUnpaidSubheads'])->name('admin.fetchUnpaidSubheads');

    // fees slip
    Route::post('/FeeSlipUnpaidFees', [FeesSlip::class, 'UnpaidFees'])->name('admin.FeeSlipUnpaidFees');
    Route::post('/PayUnpaidFees', [FeesSlip::class, 'PayUnpaidFees'])->name('admin.PayUnpaidFees');
    Route::post('/UnpaidPaidFees', [FeesSlip::class, 'UnpaidPaidFees'])->name('admin.UnpaidPaidFees');
    Route::post('/UnRevereddPaidFees', [FeesSlip::class, 'UnRevereddPaidFees'])->name('admin.UnRevereddPaidFees');
    Route::post('/LoadFeesForDateModify', [FeesSlip::class, 'LoadFeesForDateModify'])->name('admin.LoadFeesForDateModify');
    Route::post('/ModifyRecieveDate', [FeesSlip::class, 'ModifyRecieveDate'])->name('admin.ModifyRecieveDate');
    Route::post('/TotalUnpaidStudents', [FeesSlip::class, 'TotalUnpaidStudents'])->name('admin.TotalUnpaidStudents');

    // ReportStudents
    Route::post('/classWiseContact', [ReportStudents::class, 'ShowClassWiseContact'])->name('admin.classWiseContact');
    Route::post('/justClassWiseContact', [ReportStudents::class, 'justClassWiseContact'])->name('admin.justClassWiseContact');
    Route::post('/classAndSectionWiseList', [ReportStudents::class, 'classAndSectionWiseList'])->name('admin.classAndSectionWiseList');
    Route::post('/ClassWiseList', [ReportStudents::class, 'ClassWiseList'])->name('admin.ClassWiseList');
    Route::post('/AttendenceRegister', [ReportStudents::class, 'AttendenceRegister'])->name('admin.AttendenceRegister');
    Route::post('/AllAttendenceRegister', [ReportStudents::class, 'AllAttendenceRegister'])->name('admin.AllAttendenceRegister');
    Route::post('/ClassWiseStrength', [ReportStudents::class, 'ClassWiseStrength'])->name('admin.ClassWiseStrength');
    Route::post('/SingleBusRegister', [ReportStudents::class, 'SingleBusRegister'])->name('admin.SingleBusRegister');
    Route::post('/AllBusRegister', [ReportStudents::class, 'AllBusRegister'])->name('admin.AllBusRegister');
    Route::post('/SchoolLeavingCertificate', [ReportStudents::class, 'SchoolLeavingCertificate'])->name('admin.SchoolLeavingCertificate');
    Route::post('/MatriculatedStudents', [ReportStudents::class, 'MatriculatedStudents'])->name('admin.MatriculatedStudents');
    Route::post('/SLCStudentsList', [ReportStudents::class, 'SLCStudentsList'])->name('admin.SLCStudentsList');
    Route::post('/SLCStudents', [ReportStudents::class, 'SLCStudents'])->name('admin.SLCStudents');

    // save cirtificate
    Route::post('/SaveSchoolLeavingCertificate', [SchooleavingcirtificateController::class, 'store'])->name('admin.SaveSchoolLeavingCertificate');



    // Fee Reports
    Route::post('/Outstanding', [FeeReports::class, 'Outstanding'])->name('admin.Outstanding');
    Route::post('/OutstandingPaid', [FeeReports::class, 'OutstandingPaid'])->name('admin.OutstandingPaid');
    Route::post('/ClassWiseOutstanding', [FeeReports::class, 'ClassWiseOutstanding'])->name('admin.ClassWiseOutstanding');
    Route::post('/ClassAndSectionWiseOutstanding', [FeeReports::class, 'ClassAndSectionWiseOutstanding'])->name('admin.ClassAndSectionWiseOutstanding');
    Route::post('/HeadWiseFeeReports', [FeeReports::class, 'HeadWiseFeeReports'])->name('admin.HeadWiseFeeReports');

    // Expense and Income reports
    Route::post('/ExpenseReport', [ExpenseReportController::class, 'ExpenseReport'])->name('admin.ExpenseReport');
    Route::post('/AccountReport', [ExpenseReportController::class, 'AccountReport'])->name('admin.AccountReport');
    Route::post('/NetProfit', [ExpenseReportController::class, 'NetProfit'])->name('admin.NetProfit');
    Route::post('/ExpensesGroupBy', [ExpenseReportController::class, 'ExpensesGroupBy'])->name('admin.ExpensesGroupBy');
    Route::post('/AccountsGroupBy', [ExpenseReportController::class, 'AccountsGroupBy'])->name('admin.AccountsGroupBy');
    // Fee Remainder
    Route::post('/FetchStudentsForRemainder', [SMSRemainder::class, 'FetchStudentsForRemainder'])->name('admin.FetchStudentsForRemainder');
    Route::post('/FetchStudentsForRemainderClassAndSection', [SMSRemainder::class, 'FetchStudentsForRemainderClassAndSection'])->name('admin.FetchStudentsForRemainderClassAndSection');
    Route::post('/smsremainderwhole', [SMSRemainder::class, 'SMSRemainderWhole'])->name('admin.smsremainderwhole');
    Route::post('/StruckOffRemainder', [SMSRemainder::class, 'StruckOffRemainder'])->name('admin.StruckOffRemainder');

    // Examinations starts here
    // add subjects
    Route::post('/AddSubject', [SubjectsController::class, 'store'])->name('admin.AddSubject');
    Route::get('/ViewSubjects', [SubjectsController::class, 'show'])->name('admin.ViewSubjects');
    Route::get('/ViewActiveSubjects', [SubjectsController::class, 'ViewActiveSubject'])->name('admin.ViewActiveSubjects');
    Route::post('/UpdateSubject', [SubjectsController::class, 'update'])->name('admin.UpdateSubject');
    // Assign Subjects to class
    Route::post('/AssignSubject', [SubjectsController::class, 'AssignSubject'])->name('admin.AssignSubject');
    Route::get('/ViewClassWiseSubjects', [SubjectsController::class, 'ViewClassWiseSubjects'])->name('admin.ViewClassWiseSubjects');
    Route::post('/UpdateClassWiseSubject', [SubjectsController::class, 'UpdateClassWiseSubject'])->name('admin.UpdateClassWiseSubject');
    // Add Examination terms
    Route::post('/AddTerm', [SubjectsController::class, 'AddTerm'])->name('admin.AddTerm');
    Route::get('/ViewExamTerms', [SubjectsController::class, 'ViewExamTerms'])->name('admin.ViewExamTerms');
    Route::post('/UpdateExamTerm', [SubjectsController::class, 'UpdateExamTerm'])->name('admin.UpdateExamTerm');

    // Class Wise Marks
    Route::get('/FetchTermsForClassWiseMarks', [SubjectWiseMarks::class, 'FetchTermsForClassWiseMarks'])->name('admin.FetchTermsForClassWiseMarks');
    Route::get('/FetchSctionsForSubjectWiseMarks', [SubjectWiseMarks::class, 'FetchSctionsForSubjectWiseMarks'])->name('admin.FetchSctionsForSubjectWiseMarks');
    Route::get('/FetchSubjectsForSubjectWiseMarks', [SubjectWiseMarks::class, 'FetchSubjectsForSubjectWiseMarks'])->name('admin.FetchSubjectsForSubjectWiseMarks');
    Route::get('/FetchStudentsForSubjectWiseMarks', [SubjectWiseMarks::class, 'FetchStudentsForSubjectWiseMarks'])->name('admin.FetchStudentsForSubjectWiseMarks');
    Route::post('/FetchSingleStudentForSubjectWiseMarks', [SubjectWiseMarks::class, 'FetchSingleStudentForSubjectWiseMarks'])->name('admin.FetchSingleStudentForSubjectWiseMarks');

    // Examination result
    Route::post('/AddStudentsMarks', [StudentMarksController::class, 'AddStudentsMarks'])->name('admin.AddStudentsMarks');
    Route::post('/AddSingleStudentMarks', [StudentMarksController::class, 'AddSingleStudentMarks'])->name('admin.AddSingleStudentMarks');
    Route::post('/ExamResultFetchStudentInfo', [StudentMarksController::class, 'ExamResultFetchStudentInfo'])->name('admin.ExamResultFetchStudentInfo');
    Route::post('/ExamRptSinglStudent', [StudentMarksController::class, 'ExamRptSinglStudent'])->name('admin.ExamRptSinglStudent');
    Route::post('/ClassAndSectionWiseResult', [ExaminationReports::class, 'ClassAndSectionWiseResult'])->name('adminbackend.ClassAndSectionWiseResult.page');

    Route::post('/AwardListWithoutdata', [ExamReports::class, 'AwardListWithoutdata'])->name('admin.AwardListWithoutdata');
    Route::post('/AwardListWithdata', [ExamReports::class, 'AwardListWithdata'])->name('admin.AwardListWithdata');
    Route::post('/ClassandSectionWiseWithoutData', [ExamReports::class, 'ClassandSectionWiseWithoutData'])->name('admin.ClassandSectionWiseWithoutData');
    Route::post('/ClassandSectionWiseWithData', [ExamReports::class, 'ClassandSectionWiseWithData'])->name('admin.ClassandSectionWiseWithData');
    Route::post('/ClassWiseAwardListWithoutData', [ExamReports::class, 'ClassWiseAwardListWithoutData'])->name('admin.ClassWiseAwardListWithoutData');
    Route::post('/AllSubjectAwardList', [ExamReports::class, 'AllSubjectAwardList'])->name('admin.AllSubjectAwardList');
    Route::post('/ClassWiseAwardListWithData', [ExamReports::class, 'ClassWiseAwardListWithData'])->name('admin.ClassWiseAwardListWithData');
    Route::post('/PersonalDevelopmentWithoutData', [ExamReports::class, 'PersonalDevelopmentWithoutData'])->name('admin.PersonalDevelopmentWithoutData');

    // add Personal development
    Route::post('/AddPersonalDevelopment', [StudentpersonaldevelopmentController::class, 'AddPersonalDevelopment'])->name('admin.AddPersonalDevelopment');
    Route::get('/ViewPersonalDevelopment', [StudentpersonaldevelopmentController::class, 'ViewPersonalDevelopment'])->name('admin.ViewPersonalDevelopment');
    Route::post('/UpdatePersonalDevelopment', [StudentpersonaldevelopmentController::class, 'UpdatePersonalDevelopment'])->name('admin.UpdatePersonalDevelopment');
    Route::get('/FetchPersonalDevelopment', [StudentpersonaldevelopmentController::class, 'FetchPersonalDevelopment'])->name('admin.FetchPersonalDevelopment');
    Route::post('/FetchStudentsForPersonalDevelopment', [StudentpersonaldevelopmentController::class, 'FetchStudentsForPersonalDevelopment'])->name('admin.FetchStudentsForPersonalDevelopment');
    Route::post('/AddStudentPersonalDevelopment', [StudentpersonaldevelopmentController::class, 'AddStudentPersonalDevelopment'])->name('admin.AddStudentPersonalDevelopment');

    // Assign Subjects to class
    Route::post('/AssignPDT', [StudentpersonaldevelopmentController::class, 'AssignPDT'])->name('admin.AssignPDT');
    Route::get('/ViewCWPDT', [StudentpersonaldevelopmentController::class, 'ViewCWPDT'])->name('admin.ViewCWPDT');
    Route::post('/UpdateClassWisePD', [StudentpersonaldevelopmentController::class, 'UpdateClassWisePD'])->name('admin.UpdateClassWisePD');
    // AwardListWithoutdata

    // student's Comment
    Route::post('/StoreStudentsComment', [StudentsCommentController::class, 'store'])->name('admin.StoreStudentsComment');
    Route::post('/LoadStudentComment', [StudentsCommentController::class, 'show'])->name('admin.LoadStudentComment');
    Route::post('/ViewConsessionComments', [StudentsCommentController::class, 'ViewConsessionComments'])->name('admin.ViewConsessionComments');
    Route::post('/ViewPromotionComments', [StudentsCommentController::class, 'ViewPromotionComments'])->name('admin.ViewPromotionComments');
    Route::post('/CheckSLCStatus', [StudentsCommentController::class, 'CheckSLCStatus'])->name('admin.CheckSLCStatus');
    Route::post('/CancelCertificate', [StudentsCommentController::class, 'CancelCertificate'])->name('admin.CancelCertificate');

    // student promotion
    Route::post('/FetchStudentForStudentPromotion', [StudentPromotion::class, 'show'])->name('admin.FetchStudentForStudentPromotion');
    Route::post('/PromoteStudents', [StudentPromotion::class, 'PromoteStudents'])->name('admin.PromoteStudents');


    Route::resource('expenses', ExpenseController::class);
    Route::resource('expenseheads', ExpenseHeadController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('accountdetails', AccountDetailController::class);

    Route::post('/seachAccountDetails', [AccountDetailController::class, 'searchDetails']);
    Route::post('/searchExpenses', [ExpenseController::class, 'searchExpenses']);
    Route::resource('/staffattendance', StaffAttendanceController::class);

    Route::resource('locations', LocationController::class);
    Route::resource('times', TimeController::class);
    Route::resource('classwiseteachers', ClassWiseTeacherController::class);
    Route::resource('/adminpages', PagesController::class);

    // time table
    Route::resource('timetables', TimeTableController::class);
    Route::post('/PrintTimeTables', [TimeTableController::class, 'PrintTimeTables'])->name('admin.PrintTimeTables');
    Route::post('/fetchTeacherWiseClasses', [TimeTableController::class, 'fetchTeacherWiseClasses'])->name('admin.fetchTeacherWiseClasses');
    Route::post('/fetchSectionsForTeacher', [TimeTableController::class, 'fetchSectionsForTeacher'])->name('admin.fetchSectionsForTeacher');
    Route::post('/fetchSubjecsForClasses', [TimeTableController::class, 'fetchSubjecsForClasses'])->name('admin.fetchSubjecsForClasses');
    Route::post('/fetchStudentForAttendance', [StudentAttendanceController::class, 'fetchStudentForAttendance'])->name('admin.fetchStudentForAttendance');
    Route::post('/saveAttendance', [StudentAttendanceController::class, 'saveAttendance'])->name('admin.saveAttendance');
    Route::post('/StudentAttendanceReportDateWise', [StudentAttendanceController::class, 'StudentAttendanceReportDateWise'])->name('admin.StudentAttendanceReportDateWise');
    Route::post('/StudentAttendanceReportCount', [StudentAttendanceController::class, 'StudentAttendanceReportCount'])->name('admin.StudentAttendanceReportCount');
    Route::resource('companies', CompanyController::class);
    Route::resource('maincategories', MainCategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('stocktransactions', TransactionController::class);
    Route::resource('dispatches', AddStock::class);
    Route::get('/dispatchesprint', [AddStock::class, 'PrintDispatch']);
    Route::get('/loadUsers', [AddStock::class, 'loadUsers']);
    Route::get('/getUserBillNumber', [AddStock::class, 'getUserBillNumber']);
    Route::resource('companywallet', CompanyWalletController::class);
    Route::resource('userwallet', UserWalletController::class);
});


Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    return view('user.index');
})->name('dashboard');


Route::get('/user/logout', [MainController::class, 'Logout'])->name('user.logout');
Route::get('/user/profile', [MainController::class, 'UserProfile'])->name('user.profile');
Route::get('/user/profile/edit', [MainController::class, 'UserProfileEdit'])->name('user.profile.edit');
