<!-- resources/views/users.blade.php -->

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <title>قائمة المستخدمين</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        img.user-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        .approved {
            color: green;
            font-weight: bold;
        }
        .not-approved {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">قائمة المستخدمين</h2>

    @if($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>رقم</th>
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>رقم الهاتف</th>
                    <th>رقم الكارت</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($user->image)
                                <img class="user-image" src="{{ $user->image }}" alt="صورة {{ $user->name }}">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->card_number }}</td>
                        <td>
                            @if($user->approved)
                                <span class="approved">مفعل</span>
                            @else
                                <span class="not-approved">غير مفعل</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center;">لا يوجد مستخدمين لعرضهم.</p>
    @endif

</body>
</html>
