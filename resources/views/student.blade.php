<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-buttons {
            display: flex;
            gap: 10px;
        }

        h2 {
            color: #333;
        }

        .add-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-button:hover {
            background-color: #45a049;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            background: #d4edda;
            color: #155724;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #ccc;
            width: 500px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
        }

        .close:hover {
            color: #333;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        form div {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        input {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            grid-column: span 2;
            padding: 12px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .action-btns {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .edit-btn:hover {
            background-color: #0069d9;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .edit-btn, .delete-btn {
            color: white;
            border: none;
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Student List</h2>
        <div class="header-buttons">
            <button class="add-button" onclick="openModal()">+ Add Student</button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if($students->isEmpty())
        <div class="no-data">No students found.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Birthdate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $stu)
                    <tr>
                        <td>{{ $stu->id }}</td>
                        <td>{{ $stu->firstname }}</td>
                        <td>{{ $stu->middlename }}</td>
                        <td>{{ $stu->lastname }}</td>
                        <td>{{ $stu->age }}</td>
                        <td>{{ $stu->birthdate }}</td>
                        <td class="action-btns">
                            <button class="edit-btn" onclick='editStudent(@json($stu))'>Edit</button>
                            <form action="{{ route('student.destroy', $stu->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Modal Form -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 style="text-align:center; margin-bottom: 20px;" id="modalTitle">Add Student</h3>
        <form method="POST" id="studentForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div>
                <label>First Name</label>
                <input type="text" name="firstname" id="firstname" required>
            </div>
            <div>
                <label>Middle Name</label>
                <input type="text" name="middlename" id="middlename">
            </div>
            <div>
                <label>Last Name</label>
                <input type="text" name="lastname" id="lastname" required>
            </div>
            <div>
                <label>Age</label>
                <input type="number" name="age" id="age" required>
            </div>
            <div>
                <label>Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" required>
            </div>
            <button type="submit" class="submit-btn">Save Student</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('studentModal');
    const form = document.getElementById('studentForm');
    const method = document.getElementById('formMethod');
    const title = document.getElementById('modalTitle');

    function openModal() {
        form.reset();
        title.innerText = "Add Student";
        form.action = "{{ route('student.store') }}";
        method.value = "POST";
        modal.style.display = 'block';
    }

    function editStudent(student) {
        openModal();
        title.innerText = "Edit Student";
        form.action = `/students/${student.id}/update`;
        method.value = "POST";
        document.getElementById('firstname').value = student.firstname;
        document.getElementById('middlename').value = student.middlename;
        document.getElementById('lastname').value = student.lastname;
        document.getElementById('age').value = student.age;
        document.getElementById('birthdate').value = student.birthdate;
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>
