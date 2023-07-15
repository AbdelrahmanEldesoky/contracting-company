<style>

    /*.centrar {*/
    /*    text-align: center;*/
    /*}*/

    /*.derecha {*/
    /*    text-align: center;*/

    /*}*/

    /*.negrita {*/
    /*    font-weight: bold;*/
    /*}*/
    /*@media print {*/
    /*    body{*/
    /*       !*width:8.26px!important;*!*/
    /*       !*min-height: 11.69px !important;*!*/
    /*       !* overflow:hidden ;*!*/
    /*    }*/

    /*  td,th{*/
    /*      border: 1px solid #000000 ;*/
    /*  }*/
    /*}*/
    /*@page {*/
    /*    margin: 2cm;*/
    /*}*/


    /*.tabla thead {*/
    /*    background-color: #0066cc;*/
    /*    color: white;*/
    /*}*/


    * {
        font-size: 12px;
        font-family: 'Times New Roman';
        text-align: center;
    }

    td,
    th,
    tr,
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td.description,
    th.description {
        width: 55%;
        max-width: 55%;
    }

    td.quantity,
    th.quantity {
        width: 20%;
        max-width: 20%;
        word-break: break-all;
    }

    td.price,
    th.price {
        width: 25%;
        max-width: 25%;
        word-break: break-all;
        text-align: center;
    }

    .centered {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 80mm;
        max-width: 80mm;
    }

    img {
        max-width: 50mm;
        width: 50mm;

    }

    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }

</style>
{{--@yield('css')--}}













<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="ticket">
    <img src="https://i.ibb.co/VLN7v4T/logo2.png" alt="Logo" >
    <p class="centered">Slow-Cooked Tajine Restaurat
        <br>Lighthouse, Dahab, South Sinai
        <br>يااااااااااااارب
    </p>
    <table class="centered" align="Center">

        <thead>
        <tr>
            <th class="description">Name</th>
            <th class="quantity">Quantity</th>
            <th class="price">Price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            

            <td class="description"></td>
            <td class="quantity"></td>
            <td class="price"></td>
        </tr>
        
        </tbody>
    </table>
    <h3 >Total Price : <span></span></h3>
    <p class="centered">Thanks for your purchase!</p>
</div>
<script>
    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });
</script>
</body>
</html>

