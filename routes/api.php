<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademicPeriodController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\CampuseController;
use App\Http\Controllers\ClassGroupsController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\EnrollmentDocumentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\GradeSubjectController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\InstitutionDocumentController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ModuleEnrollmentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RequirementTypeController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\StudentGuardianController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserSystemController;

use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);

// Academic_Period
Route::get('academic-periods/list', [AcademicPeriodController::class, 'index'])->name('api.v1.academic_periods.index');
Route::post('academic-periods/store', [AcademicPeriodController::class, 'store'])->name('api.v1.academic_periods.store');
Route::get('academic-periods/{id}', [AcademicPeriodController::class, 'show'])->name('api.v1.academic_periods.show');
Route::put('academic-periods/{academic_period}', [AcademicPeriodController::class, 'update'])->name('api.v1.academic_period.update');
Route::delete('academic-periods/{academic_period}', [AcademicPeriodController::class, 'destroy'])->name('api.v1.academic_period.destroy');

// Academic_Year
Route::get('academic-years/list', [AcademicYearController::class, 'index'])->name('api.v1.academic_years.index');
Route::post('academic-years/store', [AcademicYearController::class, 'store'])->name('api.v1.academic_years.store');
Route::get('academic-years/{id}', [AcademicYearController::class, 'show'])->name('api.v1.academic_years.show');
Route::put('academic-years/{academic_year}', [AcademicYearController::class, 'update'])->name('api.v1.academic_year.update');
Route::delete('academic-years/{academic_year}', [AcademicYearController::class, 'destroy'])->name('api.v1.academic_year.destroy');

// Campuse
Route::get('campuses/list', [CampuseController::class, 'index'])->name('api.v1.campuses.index');
Route::post('campuses/store', [CampuseController::class, 'store'])->name('api.v1.campuses.store');
Route::get('campuses/{id}', [CampuseController::class, 'show'])->name('api.v1.campuses.show');
Route::put('campuses/{campuse}', [CampuseController::class, 'update'])->name('api.v1.campuse.update');
Route::delete('campuses/{campuse}', [CampuseController::class, 'destroy'])->name('api.v1.campuse.destroy');

// Class_Groups
Route::get('class-groups/list', [ClassGroupsController::class, 'index'])->name('api.v1.class_groups.index');
Route::post('class-groups/store', [ClassGroupsController::class, 'store'])->name('api.v1.class_groups.store');
Route::get('class-groups/{id}', [ClassGroupsController::class, 'show'])->name('api.v1.class_groups.show');
Route::put('class-groups/{class_group}', [ClassGroupsController::class, 'update'])->name('api.v1.class_group.update');
Route::delete('class-groups/{class_group}', [ClassGroupsController::class, 'destroy'])->name('api.v1.class_group.destroy');

// Contact_Message
Route::get('contact-messages/list', [ContactMessageController::class, 'index'])->name('api.v1.contact_messages.index');
Route::post('contact-messages/store', [ContactMessageController::class, 'store'])->name('api.v1.contact_messages.store');
Route::get('contact-messages/{id}', [ContactMessageController::class, 'show'])->name('api.v1.contact_messages.show');
Route::put('contact-messages/{contact_message}', [ContactMessageController::class, 'update'])->name('api.v1.contact_messages.update');
Route::delete('contact-messages/{contact_message}', [ContactMessageController::class, 'destroy'])->name('api.v1.contact_messages.destroy');

// Enrollment_Document
Route::get('enrollment-documents/list', [EnrollmentDocumentController::class, 'index'])->name('api.v1.enrollment_documents.index');
Route::post('enrollment-documents/store', [EnrollmentDocumentController::class, 'store'])->name('api.v1.enrollment_documents.store');
Route::get('enrollment-documents/{id}', [EnrollmentDocumentController::class, 'show'])->name('api.v1.enrollment_documents.show');
Route::put('enrollment-documents/{enrollment_document}', [EnrollmentDocumentController::class, 'update'])->name('api.v1.enrollment_documents.update');
Route::delete('enrollment-documents/{enrollment_document}', [EnrollmentDocumentController::class, 'destroy'])->name('api.v1.enrollment_documents.destroy');

// Enrollment
Route::get('enrollments/list', [EnrollmentController::class, 'index'])->name('api.v1.enrollments.index');
Route::post('enrollments/store', [EnrollmentController::class, 'store'])->name('api.v1.enrollments.store');
Route::get('enrollments/{id}', [EnrollmentController::class, 'show'])->name('api.v1.enrollments.show');
Route::put('enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('api.v1.enrollments.update');
Route::delete('enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('api.v1.enrollments.destroy');

// Grade_level
Route::get('grade-levels/list', [GradeLevelController::class, 'index'])->name('api.v1.grade_levels.index');
Route::post('grade-levels/store', [GradeLevelController::class, 'store'])->name('api.v1.grade_levels.store');
Route::get('grade-levels/{id}', [GradeLevelController::class, 'show'])->name('api.v1.grade_levels.show');
Route::put('grade-levels/{grade_level}', [GradeLevelController::class, 'update'])->name('api.v1.grade_level.update');
Route::delete('grade-levels/{grade_level}', [GradeLevelController::class, 'destroy'])->name('api.v1.grade_level.destroy');

// Grade_Subject
Route::get('grade-subjects/list', [GradeSubjectController::class, 'index'])->name('api.v1.grade_subjects.index');
Route::post('grade-subjects/store', [GradeSubjectController::class, 'store'])->name('api.v1.grade_subjects.store');
Route::get('grade-subjects/{id}', [GradeSubjectController::class, 'show'])->name('api.v1.grade_subjects.show');
Route::put('grade-subjects/{grade_subject}', [GradeSubjectController::class, 'update'])->name('api.v1.grade_subjects.update');
Route::delete('grade-subjects/{grade_subject}', [GradeSubjectController::class, 'destroy'])->name('api.v1.grade_subjects.destroy');

// Guardian
Route::get('guardians/list', [GuardianController::class, 'index'])->name('api.v1.guardians.index');
Route::post('guardians/store', [GuardianController::class, 'store'])->name('api.v1.guardians.store');
Route::get('guardians/{id}', [GuardianController::class, 'show'])->name('api.v1.guardians.show');
Route::put('guardians/{guardian}', [GuardianController::class, 'update'])->name('api.v1.guardians.update');
Route::delete('guardians/{guardian}', [GuardianController::class, 'destroy'])->name('api.v1.guardians.destroy');

// Institution_Document
Route::get('institution-documents/list', [InstitutionDocumentController::class, 'index'])->name('api.v1.institution_documents.index');
Route::post('institution-documents/store', [InstitutionDocumentController::class, 'store'])->name('api.v1.institution_documents.store');
Route::get('institution-documents/{id}', [InstitutionDocumentController::class, 'show'])->name('api.v1.institution_documents.show');
Route::put('institution-documents/{institution_document}', [InstitutionDocumentController::class, 'update'])->name('api.v1.institution_documents.update');
Route::delete('institution-documents/{institution_document}', [InstitutionDocumentController::class, 'destroy'])->name('api.v1.institution_documents.destroy');

// Institution
Route::get('institutions/list', [InstitutionController::class, 'index'])->name('api.v1.institutions.index');
Route::post('institutions/store', [InstitutionController::class, 'store'])->name('api.v1.institutions.store');
Route::get('institutions/{id}', [InstitutionController::class, 'show'])->name('api.v1.institutions.show');
Route::put('institutions/{institution}', [InstitutionController::class, 'update'])->name('api.v1.institutions.update');
Route::delete('institutions/{institution}', [InstitutionController::class, 'destroy'])->name('api.v1.institutions.destroy');

// Requirement_Type
Route::get('requirement-types/list', [RequirementTypeController::class, 'index'])->name('api.v1.requirement_types.index');
Route::post('requirement-types/store', [RequirementTypeController::class, 'store'])->name('api.v1.requirement_types.store');
Route::get('requirement-types/{id}', [RequirementTypeController::class, 'show'])->name('api.v1.requirement_types.show');
Route::put('requirement-types/{requirement_type}', [RequirementTypeController::class, 'update'])->name('api.v1.requirement_types.update');
Route::delete('requirement-types/{requirement_type}', [RequirementTypeController::class, 'destroy'])->name('api.v1.requirement_types.destroy');

// Requirement
Route::get('requirements/list', [RequirementController::class, 'index'])->name('api.v1.requirements.index');
Route::post('requirements/store', [RequirementController::class, 'store'])->name('api.v1.requirements.store');
Route::get('requirements/{id}', [RequirementController::class, 'show'])->name('api.v1.requirements.show');
Route::put('requirements/{requirement}', [RequirementController::class, 'update'])->name('api.v1.requirements.update');
Route::delete('requirements/{requirement}', [RequirementController::class, 'destroy'])->name('api.v1.requirements.destroy');

// Rol
Route::get('rols/list', [RolController::class, 'index'])->name('api.v1.rols.index');
Route::post('rols/store', [RolController::class, 'store'])->name('api.v1.rols.store');
Route::get('rols/{id}', [RolController::class, 'show'])->name('api.v1.rols.show');
Route::put('rols/{rol}', [RolController::class, 'update'])->name('api.v1.rols.update');
Route::delete('rols/{rol}', [RolController::class, 'destroy'])->name('api.v1.rols.destroy');

// Staff_Profile
Route::get('staff-profiles/list', [StaffProfileController::class, 'index'])->name('api.v1.staff_profiles.index');
Route::post('staff-profiles/store', [StaffProfileController::class, 'store'])->name('api.v1.staff_profiles.store');
Route::get('staff-profiles/{id}', [StaffProfileController::class, 'show'])->name('api.v1.staff_profiles.show');
Route::put('staff-profiles/{staff_profile}', [StaffProfileController::class, 'update'])->name('api.v1.staff_profiles.update');
Route::delete('staff-profiles/{staff_profile}', [StaffProfileController::class, 'destroy'])->name('api.v1.staff_profiles.destroy');

// Student_Guardian
Route::get('student-guardians/list', [StudentGuardianController::class, 'index'])->name('api.v1.student_guardians.index');
Route::post('student-guardians/store', [StudentGuardianController::class, 'store'])->name('api.v1.student_guardians.store');
Route::get('student-guardians/{id}', [StudentGuardianController::class, 'show'])->name('api.v1.student_guardians.show');
Route::put('student-guardians/{student_guardian}', [StudentGuardianController::class, 'update'])->name('api.v1.student_guardians.update');
Route::delete('student-guardians/{student_guardian}', [StudentGuardianController::class, 'destroy'])->name('api.v1.student_guardians.destroy');

// Student
Route::get('students/list', [StudentController::class, 'index'])->name('api.v1.students.index');
Route::post('students/store', [StudentController::class, 'store'])->name('api.v1.students.store');
Route::get('students/by-document', [StudentController::class, 'byDocument'])->name('api.v1.students.by_document');
Route::get('students/{id}', [StudentController::class, 'show'])->name('api.v1.students.show');
Route::put('students/{student}', [StudentController::class, 'update'])->name('api.v1.students.update');
Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('api.v1.students.destroy');

// Subject
Route::get('subjects/list', [SubjectController::class, 'index'])->name('api.v1.subjects.index');
Route::post('subjects/store', [SubjectController::class, 'store'])->name('api.v1.subjects.store');
Route::get('subjects/{id}', [SubjectController::class, 'show'])->name('api.v1.subjects.show');
Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('api.v1.subjects.update');
Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])->name('api.v1.subjects.destroy');

// Teacher
Route::get('teachers/list', [TeacherController::class, 'index'])->name('api.v1.teachers.index');
Route::post('teachers/store', [TeacherController::class, 'store'])->name('api.v1.teachers.store');
Route::get('teachers/{id}', [TeacherController::class, 'show'])->name('api.v1.teachers.show');
Route::put('teachers/{teacher}', [TeacherController::class, 'update'])->name('api.v1.teachers.update');
Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy'])->name('api.v1.teachers.destroy');

// UserSystem
Route::get('user-systems/list', [UserSystemController::class, 'index'])->name('api.v1.user_systems.index');
Route::post('user-systems/store', [UserSystemController::class, 'store'])->name('api.v1.user_systems.store');
Route::get('user-systems/{id}', [UserSystemController::class, 'show'])->name('api.v1.user_systems.show');
Route::put('user-systems/{user_system}', [UserSystemController::class, 'update'])->name('api.v1.user_system.update');
Route::delete('user-systems/{user_system}', [UserSystemController::class, 'destroy'])->name('api.v1.user_system.destroy');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('api.v1.logout');
    Route::get('teacher/profile', [TeacherController::class, 'profile'])->name('api.v1.teacher.profile');

    // Teachers only receive their own modules through the shared list endpoint.
    Route::get('modules/list', [ModuleController::class, 'index'])->name('api.v1.modules.index');
    Route::post('modules/store', [ModuleController::class, 'salida'])->name('api.v1.modules.store');
    Route::get('modules/{id}', [ModuleController::class, 'show'])->name('api.v1.modules.show');
    Route::put('modules/{module}', [ModuleController::class, 'update'])->name('api.v1.modules.update');
    Route::delete('modules/{module}', [ModuleController::class, 'destroy'])->name('api.v1.modules.destroy');

    Route::get('module-enrollments/list', [ModuleEnrollmentController::class, 'index'])->name('api.v1.module_enrollments.index');
    Route::post('module-enrollments/store', [ModuleEnrollmentController::class, 'store'])->name('api.v1.module_enrollments.store');
    Route::get('module-enrollments/{id}', [ModuleEnrollmentController::class, 'show'])->name('api.v1.module_enrollments.show');
    Route::put('module-enrollments/{module_enrollment}', [ModuleEnrollmentController::class, 'update'])->name('api.v1.module_enrollments.update');
    Route::delete('module-enrollments/{module_enrollment}', [ModuleEnrollmentController::class, 'destroy'])->name('api.v1.module_enrollments.destroy');

    Route::get('grades/list', [GradeController::class, 'index'])->name('api.v1.grades.index');
    Route::post('grades/store', [GradeController::class, 'salida'])->name('api.v1.grades.store');
    Route::get('grades/{id}', [GradeController::class, 'show'])->name('api.v1.grades.show');
    Route::put('grades/{grade}', [GradeController::class, 'update'])->name('api.v1.grades.update');
    Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('api.v1.grades.destroy');
});