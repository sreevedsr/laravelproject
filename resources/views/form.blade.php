<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        button.edit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
        }

        button.edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-left">
            <h1 id="form-title">Submit Form</h1>

            {{-- Show success message --}}
            @if(session('success'))
                <p style="color:green;">{{ session('success') }}</p>
            @endif

            {{-- Form --}}
            <form id="main-form" action="{{ route('form.handle') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="form-id" value="">

                <label>First Name:</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <label>Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <label>Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <label>Phone:</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
                @error('phone')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <button type="submit" id="submit-btn">Submit</button>
            </form>
        </div>
        
        <div class="form-right">
            @if($forms->count() > 0)
                <h2>Submitted Forms</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $form)
                                <tr>
                                    <td>{{ $form->id }}</td>
                                    <td>{{ $form->first_name }}</td>
                                    <td>{{ $form->last_name }}</td>
                                    <td>{{ $form->email }}</td>
                                    <td>{{ $form->phone ?? 'N/A' }}</td>
                                    <td>{{ $form->created_at }}</td>
                                    <td>
                                        <button type="button" class="edit-btn" 
                                            data-id="{{ $form->id }}"
                                            data-first_name="{{ $form->first_name }}"
                                            data-last_name="{{ $form->last_name }}"
                                            data-email="{{ $form->email }}"
                                            data-phone="{{ $form->phone }}">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No forms submitted yet.</p>
            @endif
        </div>
    </div>

    <script>
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {

                const id = button.getAttribute('data-id');
                const firstName = button.getAttribute('data-first_name');
                const lastName = button.getAttribute('data-last_name');
                const email = button.getAttribute('data-email');
                const phone = button.getAttribute('data-phone');

                document.getElementById('form-id').value = id;
                document.getElementById('first_name').value = firstName;
                document.getElementById('last_name').value = lastName;
                document.getElementById('email').value = email;
                document.getElementById('phone').value = phone;

                document.getElementById('form-title').innerText = 'Edit Form';
                document.getElementById('submit-btn').innerText = 'Update';
            });
        });
    </script>
</body>

</html>
