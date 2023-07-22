<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Export Books</title>
</head>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    th,
    tr {
        padding: 5px 0px;
    }

    th {
        background-color: rgb(226, 226, 226);
    }
</style>

<body>
    <div align="center">
        <h1>Data Buku</h1>
    </div>

    <div>
        <table border="1" width="100%">
            <thead>
                <th>No</th>
                <th>Cover</th>
                <th>Creator</th>
                <th>Title</th>
                <th>Category</th>
                <th>Number of Pages</th>
                <th>Description</th>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img width="100" src="{{ asset('storage/'.$item->cover) }}" alt="">
                        </td>
                        <td>{{ $item->author->name }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->number_of_pages }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
