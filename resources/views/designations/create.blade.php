<!DOCTYPE html>
<html>
<head>
    <title>Add Designation</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn {
            color: red;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-left">
            <h1>Add Designation</h1>

            @if(session('success'))
                <p style="color:green;">{{ session('success') }}</p>
            @endif

            <form action="{{ route('designations.store') }}" method="POST">
                @csrf
                <label>Designation Name:</label>
                <input type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>
                <button type="submit">Add Designation</button>
            </form>
        </div>

        <div class="form-right">
            <h2>Existing Designations</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Designation</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designations as $designation)
                        <tr>
                            <td>{{ $designation->id }}</td>
                            <td>{{ $designation->name }}</td>
                            <td>{{ $designation->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('designations.destroy', $designation->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($designations->isEmpty())
                        <tr>
                            <td colspan="4" style="text-align:center;">No designations found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
