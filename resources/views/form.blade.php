<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" />

</head>

<body>
    <div class="form-container">
        <div class="form-left">
            <h1 id="form-title">Submit Form</h1>

            @if(session('success'))
                <p style="color:green;">{{ session('success') }}</p>
            @endif

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

                <label>Designation:</label>
                <select name="designation_id" id="designation_id">
                    <option value="">Select Designation</option>
                    @foreach($designations as $designation)
                        <option value="{{ $designation->id }}">
                            {{ $designation->name }}
                        </option>
                    @endforeach
                </select>
                @error('designation_id')
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
            <h2>Submitted Forms</h2>
            <form action="{{ route('forms.index') }}" method="GET"
                style="display: flex; gap: 10px; align-items: baseline;margin-bottom:10px;">

                <input type="text" name="search" id="search" placeholder="Search by name or email"
                    value="{{ request('search') }}" style="width: auto;">

                <label>From:</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" style="width: auto;">
                <label>To:</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" style="width: auto;">

                <button type="submit"
                    style=" background-color: #007BFF; color: white; border: none; cursor: pointer; width: 100px;">Filter</button>
                <a href="{{ route('forms.index') }}"
                style="padding: 12px; background-color: gray; color: white; text-decoration: none; border-radius: 8px; width: auto;">Reset</a>
            </form>
            @if($forms->count() > 0)
                <div id="results" class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Submitted At</th>
                                <th>Designation</th>
                                <th style="text-align: center;">Action</th>
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
                                    <td>{{ $form->designation->name}}</td>
                                    <td style="display: flex; flex-direction: row; gap: 10px;justify-content:center;">

                                        <button type="button" class="edit-btn" data-id="{{ $form->id }}"
                                            data-first_name="{{ $form->first_name }}" data-last_name="{{ $form->last_name }}"
                                            data-email="{{ $form->email }}" data-phone="{{ $form->phone }}">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <form action="{{ route('form.delete', $form->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="delete-btn" data-id="{{ $form->id }}"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @if($isFiltered)
                    <p class="para">No results found for your search/filter.</p>
                @else
                    <p class="para">No forms submitted yet.</p>
                @endif
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value;

            fetch(`/forms/search?search=${query}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('results').innerHTML = html;
                })
                .catch(error => console.error(error));
        });
    });
    document.addEventListener("DOMContentLoaded", () => {
        const deleteButtons = document.querySelectorAll(".delete-btn");
        const deleteForm = document.getElementById("deleteForm");

        deleteButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                let formId = btn.getAttribute("data-id");
                deleteForm.action = `/form/${formId}`;
            });
        });
    });
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("deleteModal");
        const closeBtn = document.querySelector(".custom-modal .close");
        const cancelBtn = document.getElementById("cancelBtn");
        const deleteForm = document.getElementById("deleteForm");

        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                const formId = btn.getAttribute("data-id");
                deleteForm.action = `/form/${formId}`;
                modal.style.display = "flex";
            });
        });

        closeBtn.addEventListener("click", () => modal.style.display = "none");
        cancelBtn.addEventListener("click", () => modal.style.display = "none");

        window.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });

</script>
<div id="deleteModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close">&times;</span>
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this form?</p>

        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" id="cancelBtn">Cancel</button>
                <button type="submit" class="danger">Delete</button>
            </div>
        </form>
    </div>
</div>


</html>