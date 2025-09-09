@if($forms->count() > 0)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Submitted At</th>
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
                    <td style="display: flex; flex-direction: row; gap: 10px;">

                        <button type="button" class="edit-btn" data-id="{{ $form->id }}"
                            data-first_name="{{ $form->first_name }}" data-last_name="{{ $form->last_name }}"
                            data-email="{{ $form->email }}" data-phone="{{ $form->phone }}" style="
                                                                                            background-color: #4CAF50;
                                                                                            color: white;
                                                                                            border: none;
                                                                                            width: 36px;
                                                                                            height: 36px;
                                                                                            border-radius: 18px;
                                                                                            display: flex;
                                                                                            align-items: center;
                                                                                            justify-content: center;
                                                                                            cursor: pointer;
                                                                                            font-size: 16px;
                                                                                        ">
                            <i class="fas fa-pen"></i>
                        </button>

                        <form action="{{ route('form.delete', $form->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this form?');" style="background-color: red;
                                                                                                color: white;
                                                                                                border: none;
                                                                                                width: 36px;
                                                                                                height: 36px;
                                                                                                border-radius: 18px;
                                                                                                display: flex;
                                                                                                align-items: center;
                                                                                                justify-content: center;
                                                                                                cursor: pointer;
                                                                                                font-size: 16px;
                                                                                            ">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
@else
    @if($isFiltered)
        <p class="para">No records found<p>
    @else
        <p class="para">No forms submitted yet.</p>
    @endif
@endif