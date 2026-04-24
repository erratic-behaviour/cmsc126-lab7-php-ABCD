function searchStudent() {
    const id = document.getElementById("student-number").value;

    fetch("search_studentID.php?student_number=" + id)
        .then(res => res.json())
        .then(data => {

            if (data.status === "not_found") {
                alert("Student not found!");
                return;
            }

            document.getElementById("name-input").value = data.name || "";
            document.getElementById("age-input").value = data.age || "";
            document.getElementById("email-input").value = data.email || "";

            document.getElementById("course-select").value = data.course;
            document.getElementById("year-level-select").value = data.year_level;

            document.getElementById("grad-status-input").checked = (data.graduation_status == 1);
        })
        .catch(() => {
            alert("Error fetching student data");
        });
}