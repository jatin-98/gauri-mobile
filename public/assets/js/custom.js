const showToast = (type, message) => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    Toast.fire({
        icon: type,
        title: message
    });
};


function customDataTable(url, columnData, extraData = {}) {
    return $('#ajax-data-object').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        filter: true,
        scrollY: '60vh',
        scrollCollapse: true,
        paging: true,
        ajax: {
            url: url,
            data: function (d) {
                return $.extend({}, d, extraData);
            }
        },
        columns: columnData
    });
}


function deleteRecord(id, tableName, deleteUrl) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#loading-overlay').fadeIn(200);

            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    id: id,
                    tableName: tableName,
                },
                success: function (res) {
                    $('#loading-overlay').fadeOut(200);
                    response = JSON.parse(res);

                    if (response.success) {
                        showToast('success', 'Record Deleted Successfully!');

                        $('#ajax-data-object').DataTable().ajax.reload(null, false);
                    } else {
                        showToast('error', response.message || 'Unable to delete the record.');
                    }
                },
                error: function (xhr) {
                    $('#loading-overlay').fadeOut(200);
                    showToast('error', xhr)
                }
            });
        }
    });
}

function formatIndianCurrency(amount) {
    return amount.toLocaleString('en-IN', { style: 'currency', currency: 'INR' });
}

function numberToWords(num) {
    const a = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
        'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    ];
    const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    const numToWords = (n, s) => {
        let str = '';
        if (n > 19) str += b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
        else str += a[n];
        return str ? str + s : '';
    };

    if (num === 0) return 'Zero Rupees';

    const paise = Math.round((num % 1) * 100);
    num = Math.floor(num);

    let result = '';
    result += numToWords(Math.floor(num / 10000000), ' Crore ');
    result += numToWords(Math.floor((num / 100000) % 100), ' Lakh ');
    result += numToWords(Math.floor((num / 1000) % 100), ' Thousand ');
    result += numToWords(Math.floor((num / 100) % 10), ' Hundred ');
    result += numToWords(num % 100, '');

    result = result.trim() + ' Rupees';
    if (paise > 0) {
        result += ' and ' + numToWords(paise, '') + ' Paise';
    }

    return result + ' Only';
}

function navigateViaJs(url) {
    window.location.href = url;
}