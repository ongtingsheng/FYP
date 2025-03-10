document.addEventListener("DOMContentLoaded", function () {
    // Attendance Modal Handling
    document.querySelector(".view-btn").addEventListener("click", function () {
        event.preventDefault();
        document.getElementById("attendanceModal").style.display = "flex";
    });
    document.getElementById("closeAttendance").addEventListener("click", function () {
        document.getElementById("attendanceModal").style.display = "none";
    });
    window.onclick = function (event) {
        let modal = document.getElementById("attendanceModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

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
    
});


