<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <table id="studentsTable" class="table table-striped table-dark">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Name</th>
                <th>Department</th>
                <th>Midterm</th>
                <th>Final</th>
                <th>Cumulative Grade</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
             
        </tbody>
      </table>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-7j3Q1z5+6e5c"></script>

      <script>
        $(document).ready(function() {

            fetchStudents();

            function fetchStudents(){
                $.ajax({
                    url: "/api/students",
                    type: "GET",
                    datatype: "json",
                    success:function(response) {
                        let rows = '';
                        response.forEach(student => {
                            let midterm = student.grades ? student.grades.midterm : 'N/A';
                            let final = student.grades ? student.grades.final : 'N/A';
                            let cumutative = (student.grades ? ( parseFloat(midterm) + parseFloat(final) ) / 2 : 'N/A');
                            let remarks = (cumutative >3.0) ? "Failed" : "Pass";

                            rows += `
                            <tr>
                                <td>${student.id_number}</td>
                                <td>${student.firstname} ${student.middlename} ${student.lastname }</td>
                                <td>${student.department.name}</td>
                                <td>${midterm}</td>
                                <td>${final}</td>
                                <td>${cumutative}</td>
                                <td>${remarks}</td>
                            </tr>
                            `;

                        });
                        $('#studentsTable tbody').html(rows);

                    },
                    error:function(){
                        alert('Error fetching data');
                    }
                });
            }
            setInterval(fetchStudents,5000);
        });
      </script>
</body>
</html>