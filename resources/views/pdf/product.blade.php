<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #000; padding:8px; text-align:left; }
        img { max-width:100px; }
    </style>
</head>
<body>

<h2>{{ $product->name }}</h2>
<p>{{ $product->description }}</p>

<table>
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Brand Image</th>
            <th>Brand Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($product->brands as $brand)
        <tr>
            <td>{{ $brand->brand_name }}</td>
            <td>
                <img src="{{ public_path('storage/'.$brand->image) }}">
            </td>
            <td>₹{{ $brand->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total Price: ₹{{ $total }}</h3>

</body>
</html>
