$(document).ready(function () {

    /*Delete domain request*/
    $(document).on('click', ".delete-domain", function () {
        let id = $(this).attr("data-id");
        $.ajax({
            url: "/domains/" + id,
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (result) {
                if (result.status === 200) {
                    let current = $("button.delete-domain[data-id=" + id + "]");
                    current.parent("td").append("deleted").next().empty().append('<button data-id="' + id + '" class="btn btn-warning restore-domain">restore</button>');
                    current.remove();
                }
                let alertClass = result.status === 200 ? 'alert-success' : 'alert-danger';
                let notification = $(".notification");
                notification.attr('class', function (i, c) {
                    return c.replace(/(^|\s)alert-\S+/g, '');
                });
                notification.removeClass("hidden").addClass(alertClass).find("span").text(result.message);
                setTimeout(function () {
                    notification.removeClass(alertClass).addClass("hidden").find("span").text('');
                }, 4000);
            }
        });
    });

    /*Restore domain request*/
    $(document).on('click', ".restore-domain", function () {
        let id = $(this).attr("data-id");
        $.ajax({
            url: "/domains/restore/" + id,
            method: "GET",
            dataType: "json",
            success: function (result) {
                if (result.status === 200) {
                    let current = $("button.restore-domain[data-id=" + id + "]");
                    current.parent("td").append("-").prev().empty().append('<button data-id="' + id + '"class="btn btn-danger delete-domain">delete</button>');
                    current.remove();
                }
                let alertClass = result.status === 200 ? 'alert-success' : 'alert-danger';
                let notification = $(".notification");
                notification.attr('class', function (i, c) {
                    return c.replace(/(^|\s)alert-\S+/g, '');
                });
                notification.removeClass("hidden").addClass(alertClass).find("span").text(result.message);
                setTimeout(function () {
                    notification.removeClass(alertClass).addClass("hidden").find("span").text('');
                }, 4000);
            }
        });
    });

    /*Update domain request*/
    $(document).on('click', ".update-domain", function () {
        let id = $("input[name=domain_id]").val(),
            domain = $("input[name=domain]").val();
        $.ajax({
            url: "/domains/" + id,
            method: "PUT",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {domain: domain},
            dataType: "json",
            success: function (result) {
                let alertClass = result.status === 200 ? 'alert-success' : 'alert-danger';
                let notification = $(".notification");
                notification.attr('class', function (i, c) {
                    return c.replace(/(^|\s)alert-\S+/g, '');
                });
                notification.removeClass("hidden").addClass(alertClass).find("span").text(result.message);
                setTimeout(function () {
                    notification.removeClass(alertClass).addClass("hidden").find("span").text('');
                }, 4000);
            },
            error: function (result) {
                $.each(result.responseJSON.errors, function (key, val) {
                    let elem = $(".domain-error");
                    elem.removeClass("hidden").show().find("strong").text(val[0]);
                    elem.prev().addClass("is-invalid");
                });
            },
        });
    });

    /*Check domain request*/
    let ajaxReq = 'PrevReq';
    $(document).on('click keyup', ".new-domain", function () {
        let domain = $(this).val();
        $(".invalid-feedback").hide();
        if (domain) {
            ajaxReq = $.ajax({
                url: "/domains/check",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'domain': domain},
                dataType: "json",
                beforeSend: function () {
                    if (ajaxReq !== 'PrevReq' && ajaxReq.readyState < 4) {
                        ajaxReq.abort();
                    }
                },
                success: function (result) {
                    let textClass = result.status === 200 ? 'text-danger' : 'text-success';
                    let domainStatus = $(".domain-status");
                    domainStatus.attr('class', function (i, c) {
                        return c.replace(/(^|\s)text-\S+/g, '');
                    });
                    domainStatus.removeClass("hidden").addClass(textClass).text(result.message);
                    if (result.status !== 200) {
                        $(".add-domain").removeClass("hidden");
                    }
                    else {
                        $(".add-domain").addClass("hidden");
                    }
                },
            });
        }
    });


});