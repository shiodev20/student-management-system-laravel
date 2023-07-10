<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Classroom;
use App\Models\ClassroomDetail;
use App\Models\Employee;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\Rank;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingAssignment;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
    $seedData = Storage::disk('local')->get('seed/data.json');
    $seedDataDecoded = json_decode($seedData);
     
    $rules = $seedDataDecoded->rules;
    foreach ($rules as $rule) {
      Rule::create([
        'class_size' => $rule->class_size,
        'max_age' => $rule->max_age,
        'min_age' => $rule->min_age,
        'pass_mark' => $rule->pass_mark,
      ]);
    }

    $ranks = $seedDataDecoded->ranks;
    foreach ($ranks as $rank) {
      Rank::create([
        'id' => $rank->id,
        'name' => $rank->name,
        'min_value' => $rank->min_value,
        'max_value' => $rank->max_value,
      ]);
    }

    $roles = $seedDataDecoded->roles;
    foreach ($roles as $role) {
      Role::create([
        'id' => $role->id,
        'name' => $role->name,
      ]);
    }

    $years = $seedDataDecoded->years;
    foreach ($years as $year) {
      Year::create([
        'id' => $year->id,
        'name' => $year->name,
        'status' => $year->status,
      ]);
    }

    $semesters = $seedDataDecoded->semesters;
    foreach ($semesters as $semester) {
      Semester::create([
        'id' => $semester->id,
        'name' => $semester->name,
        'status' => $semester->status,
        'coefficient' => $semester->coefficient,
      ]);
    }

    $grades = $seedDataDecoded->grades;
    foreach ($grades as $grade) {
      Grade::create([
        'id' => $grade->id,
        'name' => $grade->name,
      ]);
    }

    $subjects = $seedDataDecoded->subjects;
    foreach ($subjects as $subject) {
      Subject::create([
        'id' => $subject->id,
        'name' => $subject->name,
        'coefficient' => $subject->coefficient
      ]);
    }

    $marktypes = $seedDataDecoded->marktypes;
    foreach ($marktypes as $marktype) {
      MarkType::create([
        'id' => $marktype->id,
        'name' => $marktype->name,
        'coefficient' => $marktype->coefficient
      ]);
    }

    $accounts = $seedDataDecoded->accounts;
    foreach ($accounts as $account) {
      Account::create([
        'id' => $account->id,
        'email' => $account->email,
        'password' => $account->password,
        'status' => $account->status,
        'created_at' => $account->createdAt,
        'created_at' => $account->createdAt,
      ]);
    }


    $students = $seedDataDecoded->students;
    foreach ($students as $student) {
      $idx = 1;


      Student::create([
        'id' => $student->id,
        'first_name' => $student->firstName,
        'last_name' => $student->lastName,
        'gender' => $student->gender,
        'dob' => $student->dob,
        'address' => $student->address,
        'email' => 'hs'.$idx.'@gmail.com',
        'parent_name' => $student->parentName,
        'parent_phone' => $student->parentPhone,
        'enroll_date' => $student->enrollDate,
        'role_id' => 3,
        'account_id' => $student->accountId,
      ]);

      $idx += 1;
    }

    


    $employees = $seedDataDecoded->employees;
    foreach ($employees as $employee) {
      Employee::create([
        'id' => $employee->id,
        'first_name' => $employee->firstName,
        'last_name' => $employee->lastName,
        'gender' => $employee->gender,
        'dob' => $employee->dob,
        'address' => $employee->address,
        'email' => $employee->email,
        'phone' => $employee->phone,
        'role_id' => $employee->roleId,
        'account_id' => $employee->accountId,
      ]);
    }

    $teachers = $seedDataDecoded->teachers;
    foreach ($teachers as $teacher) {
      Teacher::create([
        'id' => $teacher->id,
        'first_name' => $teacher->firstName,
        'last_name' => $teacher->lastName,
        'gender' => $teacher->gender,
        'dob' => $teacher->dob,
        'address' => $teacher->address,
        'email' => $teacher->email,
        'phone' => $teacher->phone,
        'role_id' => $teacher->roleId,
        'subject_id' => $teacher->subjectId,
        'account_id' => $teacher->accountId,
      ]);
    }

    $classrooms = $seedDataDecoded->classrooms;
    foreach ($classrooms as $classroom) {
      Classroom::create([
        'id' => $classroom->id,
        'name' => $classroom->name,
        'size' => $classroom->size,
        'grade_id' => $classroom->gradeId,
        'year_id' => $classroom->yearId,
        'head_teacher_id' => $classroom->headTeacherId,
      ]);
    }

    $teachingAssignments = $seedDataDecoded->teachingAssignments;
    foreach ($teachingAssignments as $teachingAssignment) {
      TeachingAssignment::create([
        'classroom_id' => $teachingAssignment->classroomId,
        'subject_id' => $teachingAssignment->subjectId,
        'subject_teacher_id' => $teachingAssignment->subjectTeacherId,
      ]);
    }

    $classroomDetails = $seedDataDecoded->classroomDetails;
    foreach ($classroomDetails as $classroomDetail) {
      ClassroomDetail::create([
        'classroom_id' => $classroomDetail->classroomId,
        'student_id' => $classroomDetail->studentId,
      ]);
    }

    $marks = $seedDataDecoded->marks;
    foreach ($marks as $mark) {
      Mark::create([
        'year_id' => $mark->yearId,
        'semester_id' => $mark->semesterId,
        'classroom_id' => $mark->classroomId,
        'student_id' => $mark->studentId,
        'subject_id' => $mark->subjectId,
        'mark_type_id' => $mark->markTypeId,
        'mark' => $mark->mark,
      ]);
    }
  }

}

