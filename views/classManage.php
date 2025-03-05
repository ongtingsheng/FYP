<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <link rel="stylesheet" href="../public/css/classManage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../public/js/classManage.js"></script>
    <style>
        .class-table,
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .class-table th,
        .class-table td,
        .schedule-table th,
        .schedule-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .class-table th,
        .schedule-table th {
            background: #007BFF;
            color: white;
        }

        .class-table tr:nth-child(even),
        .schedule-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            /* Prevents overflow */
            overflow-y: auto;
            /* Enables scrolling */
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Schedule Checkboxes */
        .schedule-checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .schedule-checkboxes label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .btn-submit {
            background: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        /* Formatted Schedule Display */
        .schedule-output {
            font-weight: bold;
            margin-top: 10px;
            color: #007BFF;
        }

        /* Add Student Modal */
        #addStudentModal {
            display: none;
            position: fixed;
            z-index: 2;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .student-table th,
        .student-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .student-table th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>

<?php
require_once '../models/classModel.php';
require_once '../controllers/classController.php';

$classModel = new ClassModel();
$classes = $classModel->getAllClasses();
?>

<body>
    <div class="container">
        <h1 class="header">Class <span class="highlight">Management</span></h1>
        <div class="actions">
            <button class="btn export">Export to Excel</button>
            <button class="btn add" id="openAddClass">+ Add New Class</button>
            <!-- <button class="btn import">Import from CSV</button> -->
        </div>

        <!-- Class Table -->
        <form method="POST" action="">
            <table class="class-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Subject</th>
                        <th>Class Code</th>
                        <th>Capacity</th>
                        <th>First Day</th>
                        <th>Second Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Students Assigned</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes)): ?>
                        <?php foreach ($classes as $index => $class): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($class['class_name']) ?></td>
                                <td><?= htmlspecialchars($class['subject']) ?></td>
                                <td><?= htmlspecialchars($class['subject_code']) ?></td>
                                <td><?= htmlspecialchars($class['capacity']) ?></td>
                                <td><?= htmlspecialchars($class['first_day']) ?></td>
                                <td><?= htmlspecialchars($class['last_day']) ?></td>
                                <td><?= htmlspecialchars($class['start_time']) ?></td>
                                <td><?= htmlspecialchars($class['end_time']) ?></td>

                                <td><?= $class['students_assigned'] . '/' . $class['capacity'] ?></td>
                                <td><span class="status <?= $class['status'] == 'Active' ? 'active' : 'inactive' ?>">
                                        <?= htmlspecialchars($class['status']) ?>
                                    </span></td>
                                <td>
                                    <button class="action-btn" id="add-student-btn"><i class="fas fa-user-plus"></i></button>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="edit-btn" data-id="<?= $class['class_id']; ?>"
                                        data-name="<?= $class['class_name']; ?>" data-subject="<?= $class['subject']; ?>"
                                        data-code="<?= $class['subject_code']; ?>" data-capacity="<?= $class['capacity']; ?>"
                                        data-firstday="<?= $class['first_day']; ?>" data-lastday="<?= $class['last_day']; ?>"
                                        data-start="<?= $class['start_time']; ?>" data-end="<?= $class['end_time']; ?>"
                                        data-status="<?= $class['status']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="class_id" value="<?= $class['class_id']; ?>">
                                        <button type="submit" name="action" value="delete" class="action-btn delete-btn"
                                            onclick="return confirm('Are you sure you want to delete this class?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">No classes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>

        <!-- Add Class Modal -->
        <div id="addClassModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeAddClass">&times;</span>
                <!-- Add Class Form -->
                <h2>Add New Class</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="hidden" name="action" value="add">
                    </div>
                    <div class="form-group">
                        <input type="text" name="class_name" placeholder="Class Name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject_code" placeholder="Subject Code" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="capacity" placeholder="Capacity" required>
                    </div>

                    <!-- Schedule Section -->
                    <div class="form-group">
                        <label for="scheduleDays">First Day:</label>
                        <select name="first_day" id="scheduleDays" multiple required>
                            <option value="Mon">Monday</option>
                            <option value="Tue">Tuesday</option>
                            <option value="Wed">Wednesday</option>
                            <option value="Thu">Thursday</option>
                            <option value="Fri">Friday</option>
                            <option value="Sat">Saturday</option>
                            <option value="Sun">Sunday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="scheduleDays">Last Day:</label>
                        <select name="last_day" id="scheduleDays" multiple required>
                            <option value="Mon">Monday</option>
                            <option value="Tue">Tuesday</option>
                            <option value="Wed">Wednesday</option>
                            <option value="Thu">Thursday</option>
                            <option value="Fri">Friday</option>
                            <option value="Sat">Saturday</option>
                            <option value="Sun">Sunday</option>
                        </select>
                    </div>

                    <input type="time" name="start_time" placeholder="Start Time" required>
                    <input type="time" name="end_time" placeholder="End Time" required>

                    <select name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <button type="submit">Add Class</button>
                </form>

            </div>
        </div>
        <script>
            // Add Class Modal Handling
            document.getElementById("openAddClass").addEventListener("click", function () {
                document.getElementById("addClassModal").style.display = "flex";
            });
            document.getElementById("closeAddClass").addEventListener("click", function () {
                document.getElementById("addClassModal").style.display = "none";
            });
            window.onclick = function (event) {
                let modal = document.getElementById("addClassModal");
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
        </script>
    </div>

    <!-- Attendance Dashboard Modal -->
    <div id="attendanceModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAttendance">&times;</span>
            <h2>Real-Time Attendance Dashboard</h2>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>Time Marked</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jane Smith</td>
                        <td>Mathematics 101</td>
                        <td><span class="status active">Present</span></td>
                        <td>10:02 AM</td>
                        <td><button class="action-btn"><i class="fas fa-exclamation-circle"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Class Modal -->
    <div id="editClassModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditClass">&times;</span>
            <h2>Edit Class</h2>
            <form id="editClassForm" method="POST" action="">
                <!-- Hidden input for class ID -->
                <input type="hidden" name="class_id" id="editClassId">

                <div class="form-group">
                    <label>Class Name</label>
                    <input type="text" name="class_name" id="editClassName" readonly>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" id="editClassSubject" readonly>
                </div>
                <div class="form-group">
                    <label>Subject Code</label>
                    <input type="text" name="subject_code" id="editClassCode" readonly>
                </div>
                <div class="form-group">
                    <label>Capacity</label>
                    <input type="number" name="capacity" id="editClassCapacity">
                </div>

                <!-- Schedule Section -->
                <div class="form-group">
                    <label for="editFirstDay">First Day:</label>
                    <select name="first_day" id="editFirstDay">
                        <option value="Mon">Monday</option>
                        <option value="Tue">Tuesday</option>
                        <option value="Wed">Wednesday</option>
                        <option value="Thu">Thursday</option>
                        <option value="Fri">Friday</option>
                        <option value="Sat">Saturday</option>
                        <option value="Sun">Sunday</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="editLastDay">Last Day:</label>
                    <select name="last_day" id="editLastDay">
                        <option value="Mon">Monday</option>
                        <option value="Tue">Tuesday</option>
                        <option value="Wed">Wednesday</option>
                        <option value="Thu">Thursday</option>
                        <option value="Fri">Friday</option>
                        <option value="Sat">Saturday</option>
                        <option value="Sun">Sunday</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" name="start_time" id="editStartTime" required>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" name="end_time" id="editEndTime" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editClassStatus">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                    </select>
                </div>


                <input type="hidden" name="action" value="edit">
                <button type="submit" class="btn-submit">Save Changes</button>
            </form>
        </div>
    </div>
    <script>
        // Edit Class Modal Handling
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                // Get modal
                let modal = document.getElementById("editClassModal");

                // Set form fields with existing class data
                document.getElementById("editClassId").value = this.getAttribute("data-id");
                document.getElementById("editClassName").value = this.getAttribute("data-name");
                document.getElementById("editClassSubject").value = this.getAttribute("data-subject");
                document.getElementById("editClassCode").value = this.getAttribute("data-code");
                document.getElementById("editClassCapacity").value = this.getAttribute("data-capacity");
                document.getElementById("editFirstDay").value = this.getAttribute("data-firstday");
                document.getElementById("editLastDay").value = this.getAttribute("data-lastday");
                document.getElementById("editStartTime").value = this.getAttribute("data-start");
                document.getElementById("editEndTime").value = this.getAttribute("data-end");
                document.getElementById("editClassStatus").value = this.getAttribute("data-status");
                event.preventDefault();
                // Show modal
                modal.style.display = "flex";
            });
        });

        // Close modal when clicking the close button
        document.getElementById("closeEditClass").addEventListener("click", function () {
            document.getElementById("editClassModal").style.display = "none";
        });

        // Close modal when clicking outside of it
        window.onclick = function (event) {
            let modal = document.getElementById("editClassModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddStudent">&times;</span>
            <h2>Add Students to Class</h2>

            <!-- Course Filter -->
            <div class="form-group">
                <label for="courseFilter">Filter by Course:</label>
                <select id="courseFilter">
                    <option value="all">All Courses</option>
                    <option value="course1">Course 1</option>
                    <option value="course2">Course 2</option>
                    <option value="course3">Course 3</option>
                </select>
            </div>

            <!-- Student List Table -->
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody id="studentList">
                    <tr data-course="course1">
                        <td><input type="checkbox" class="student-checkbox"></td>
                        <td>ST001</td>
                        <td>John Doe</td>
                        <td>Course 1</td>
                    </tr>
                    <tr data-course="course2">
                        <td><input type="checkbox" class="student-checkbox"></td>
                        <td>ST002</td>
                        <td>Jane Smith</td>
                        <td>Course 2</td>
                    </tr>
                    <tr data-course="course3">
                        <td><input type="checkbox" class="student-checkbox"></td>
                        <td>ST003</td>
                        <td>Mike Johnson</td>
                        <td>Course 3</td>
                    </tr>
                </tbody>
            </table>

            <!-- Add Students Button -->
            <button class="btn-submit" id="confirmAddStudents">Add Selected Students</button>
        </div>
    </div>

    <script>
        // Add Student Modal Handling
        document.getElementById("add-student-btn").addEventListener("click", function () {
            document.getElementById("addStudentModal").style.display = "flex";
            event.preventDefault();
        });

        document.getElementById("closeAddStudent").addEventListener("click", function () {
            document.getElementById("addStudentModal").style.display = "none";
        });

        window.onclick = function (event) {
            let modal = document.getElementById("addStudentModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Course Filter Functionality
        document.getElementById("courseFilter").addEventListener("change", function () {
            let selectedCourse = this.value;
            let students = document.querySelectorAll("#studentList tr");

            students.forEach(student => {
                if (selectedCourse === "all" || student.getAttribute("data-course") === selectedCourse) {
                    student.style.display = "";
                } else {
                    student.style.display = "none";
                }
            });
        });

        // Get modal elements
        const modal = document.getElementById("addClassModal");
        const closeModal = document.getElementById("closeAddClass");
        const openModal = document.getElementById("openAddClass");

        // Open modal
        openModal.addEventListener("click", () => {
            modal.style.display = "flex";
        });

        // Close modal
        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
        });

    </script>

</body>

</html>