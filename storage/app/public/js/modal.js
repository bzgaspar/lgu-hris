var deleteLinks = document.querySelectorAll(".delete");

for (var i = 0; i < deleteLinks.length; i++) {
    deleteLinks[i].addEventListener("click", function (event) {
        event.preventDefault();

        $("#delete-modal-body").empty();
        $("#delete-modal-body").append(this.getAttribute("data-confirm"));

        var action = this.getAttribute("data-target")
        $(this).get(0).setAttribute('action', action);

        $("#delete-submit-modal-btn").click(function () {
            $(this).parents("form:first").prop('action', action);
            $(this).parents("form:first").submit();
        });
    });
}

var deleteLinks = document.querySelectorAll(".patch");

for (var i = 0; i < deleteLinks.length; i++) {
    deleteLinks[i].addEventListener("click", function (event) {
        event.preventDefault();

        $("#patch-modal-body").empty();
        $("#patch-modal-body").append(this.getAttribute("data-confirm"));

        var action = this.getAttribute("data-target")
        $(this).get(0).setAttribute('action', action);

        $("#patch-submit-modal-btn").click(function () {
            $(this).parents("form:first").prop('action', action);
            $(this).parents("form:first").submit();
        });
    });
}
