<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr>
            <td>{{ $group->id }}</td>
            <td>{{ $group->title }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
