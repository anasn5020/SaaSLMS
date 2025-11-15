$(document).ready(function () {

    $(document).on("click", ".printBtn", function () {
        console.log('print')
        printDiv('invoice_print');
    });
});

function printDiv(divName) {
    let printContents = document.getElementById(divName).innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    setTimeout(function () {
        window.location.reload()
    }, 10000);
}

$(document).on("click", ".downloadBtn", function () {
    const element = document.getElementById("invoice_print");
    let opt = {
        margin: 0,
        padding:0,
        filename: 'invoice.pdf',
        image: {type: 'jpeg', quality: 1},
        jsPDF: {unit: 'in', format: 'a4', orientation: 'portrait'}
    };
    html2pdf().set(opt).from(element).save();
});
