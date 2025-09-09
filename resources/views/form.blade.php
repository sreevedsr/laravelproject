<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>
    <div class="form-container">
        <div class="form-left">
            <h1>Submit Form</h1>

            {{-- Show success message --}}
            @if(session('success'))
                <p style="color:green;">{{ session('success') }}</p>
            @endif

            {{-- Form --}}
            <form action="{{ route('form.handle') }}" method="POST">
                @csrf

                <label>First Name:</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <label>Last Name:</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <label>Phone:</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br><br>

                <button type="submit">Submit</button>
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
</body>

</html>
