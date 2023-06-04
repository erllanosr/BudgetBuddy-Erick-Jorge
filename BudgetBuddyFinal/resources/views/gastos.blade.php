<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            align-items: center;
        }
        tr {
            border-bottom: 1px solid #000;
            text-align: center;
        }
        td {
            text-align: center;
        }
        img {
            height: 200px;
            padding: 0;
        }

    </style>
</head>
<body>
    <img src="{{$imagen}}" alt="logo">
    <h1><i>Gastos</i></h1>
    <table>
        <tr>
            <th><strong>ID</strong></th>
            <th><strong>Cantidad</strong></th>
            <th><strong>Descripción</strong></th>
            <th><strong>Fecha</strong></th>
        </tr>
        @foreach ($gastos as $gasto)
            <tr>
                <td>{{ $gasto->id }}</td>
                <td>{{ $gasto->monto }}</td>
                <td>{{ $gasto->descripcion }}</td>
                <td>{{ $gasto->fecha }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
