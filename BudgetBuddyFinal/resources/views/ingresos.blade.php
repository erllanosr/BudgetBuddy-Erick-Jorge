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
    <h1>Ingresos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Monto</th>
            <th>Descripción</th>
            <th>Fecha</th>
        </tr>
        @foreach ($ingresos as $ingreso)
            <tr>
                <td>{{ $ingreso->id }}</td>
                <td>{{ $ingreso->monto }}</td>
                <td>{{ $ingreso->descripcion }}</td>
                <td>{{ $ingreso->fecha }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
