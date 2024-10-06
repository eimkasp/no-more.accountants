<html>
    <head>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="p-0 m-0">
<div style="width: 600px;" class="mx-auto bg-white p-6 shadow-lg">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold">Invoice</h1>
            <p class="text-gray-500">No: 123#</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold">NO MORE ACCT</h2>
        </div>
    </div>
    
    <!-- Payment Info -->
    <div class="mt-8 grid grid-cols-2 gap-4">
        <div>
            <p><strong>Billed to:</strong></p>
            <p>MB "Dirbtinis intelektas"</p>
            <p>Gatvė 28 g., Vilnius, Lithuania, LT-43210</p>
            <p>hello@dirbtinisintelektas.lt</p>
        </div>
        <div>
            <p><strong>Billed from:</strong></p>
            <p>Studio Linijos</p>
            <p>Gatvė 10 g., Vilnius, Lithuania, LT-01234</p>
            <p>hello@linijos.lt</p>
        </div>
    </div>

    <!-- Items Table -->
    <div class="mt-8">
        <table class="w-full table-auto text-left">
            <thead class="bg-lime-300 text-black">
                <tr>
                    <th class="py-2 px-4">Item:</th>
                    <th class="py-2 px-4">Quantity:</th>
                    <th class="py-2 px-4">Price:</th>
                    <th class="py-2 px-4">Amount:</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="py-2 px-4">Service A</td>
                    <td class="py-2 px-4">1</td>
                    <td class="py-2 px-4">100,00€</td>
                    <td class="py-2 px-4">100,00€</td>
                </tr>
                <tr class="border-t">
                    <td class="py-2 px-4">Service B</td>
                    <td class="py-2 px-4">2</td>
                    <td class="py-2 px-4">200,00€</td>
                    <td class="py-2 px-4">600,00€</td>
                </tr>
                <tr class="border-t">
                    <td class="py-2 px-4">Service C</td>
                    <td class="py-2 px-4">3</td>
                    <td class="py-2 px-4">100,00€</td>
                    <td class="py-2 px-4">300,00€</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Note -->
    <div class="mt-4">
        <p><strong>Note:</strong> Thank you for your service!</p>
    </div>

    <!-- Total -->
    <div class="mt-8">
        <div class="flex justify-between items-center">
            <div></div>
            <div class="text-right">
                <p class="text-2xl font-bold">Total: 1210,00 € (EUR)</p>
                <p>VAT: 210,00 € (EUR)</p>
                <p>SUM: 1000,00 € (EUR)</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>No More Accountants</p>
        <p>www.nomore.accountants</p>
        <p>Lithuania, Vilnius</p>
        <p>32994 8164014</p>
        <p>VAT reg no. 1234567</p>
    </div>
</div>
    </body>
</html>