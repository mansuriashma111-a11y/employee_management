<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Employee Management System')
    </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>


<body>


    @yield('content')


    <!-- ===================================================== -->
    <!-- SUCCESS / ERROR MODAL -->
    <!-- ===================================================== -->

    <div class="modal fade"
         id="successModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4">


                <!-- Header -->

                <div class="modal-header border-0">

                    <h5 class="modal-title fw-bold"
                        id="modalTitle">

                        <i class="bi bi-check-circle-fill me-2"
                           id="modalIcon"></i>

                        <span id="modalHeading">
                            Success
                        </span>

                    </h5>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- Body -->

                <div class="modal-body text-center py-4">

                    <i id="modalBodyIcon"
                       class="bi bi-check-circle-fill text-success"
                       style="font-size: 65px;">
                    </i>


                    <h4 class="fw-bold mt-3"
                        id="modalBodyHeading">

                        Success!

                    </h4>


                    <p id="successMessage"
                       class="text-muted mb-0">
                    </p>

                </div>


                <!-- Footer -->

                <div class="modal-footer border-0 justify-content-center">

                    <button type="button"
                            id="modalOkButton"
                            class="btn btn-success px-5 rounded-pill"
                            data-bs-dismiss="modal">

                        OK

                    </button>

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- COMMON DELETE CONFIRMATION MODAL -->
    <!-- ===================================================== -->

    <div class="modal fade"
         id="deleteConfirmModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4">


                <!-- Header -->

                <div class="modal-header border-0">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-trash text-danger me-2"></i>

                        Confirm Delete

                    </h5>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- Body -->

                <div class="modal-body text-center py-4">

                    <i class="bi bi-exclamation-triangle-fill text-warning"
                       style="font-size: 60px;">
                    </i>


                    <h5 class="fw-bold mt-3">
                        Are you sure?
                    </h5>


                    <p id="deleteMessage"
                       class="text-muted mb-0">

                        Are you sure you want to delete this record?

                    </p>

                </div>


                <!-- Footer -->

                <div class="modal-footer border-0 justify-content-center">


                    <button type="button"
                            class="btn btn-secondary px-4"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button type="button"
                            class="btn btn-danger px-4"
                            id="confirmDeleteBtn">

                        <i class="bi bi-trash me-1"></i>

                        Delete

                    </button>

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- jQuery -->
    <!-- ===================================================== -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- ===================================================== -->
    <!-- Bootstrap JS -->
    <!-- ===================================================== -->

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>


    <!-- ===================================================== -->
    <!-- Main JS -->
    <!-- ===================================================== -->

    <script src="{{ asset('assets/js/main.js') }}"></script>



    <!-- ===================================================== -->
    <!-- SUCCESS MODAL FUNCTION -->
    <!-- ===================================================== -->

    <script>

        function showSuccessModal(message, type = 'success') {

            if (type === 'error') {

                // Header

                $('#modalTitle')
                    .removeClass('text-success')
                    .addClass('text-danger');


                $('#modalIcon')
                    .removeClass('bi-check-circle-fill')
                    .addClass('bi-exclamation-circle-fill');


                $('#modalHeading').text('Error');


                // Body

                $('#modalBodyIcon')
                    .removeClass('bi-check-circle-fill text-success')
                    .addClass('bi-exclamation-circle-fill text-danger');


                $('#modalBodyHeading').text('Error!');


                // Button

                $('#modalOkButton')
                    .removeClass('btn-success')
                    .addClass('btn-danger');

            }

            else {

                // Header

                $('#modalTitle')
                    .removeClass('text-danger')
                    .addClass('text-success');


                $('#modalIcon')
                    .removeClass('bi-exclamation-circle-fill')
                    .addClass('bi-check-circle-fill');


                $('#modalHeading').text('Success');


                // Body

                $('#modalBodyIcon')
                    .removeClass('bi-exclamation-circle-fill text-danger')
                    .addClass('bi-check-circle-fill text-success');


                $('#modalBodyHeading').text('Success!');


                // Button

                $('#modalOkButton')
                    .removeClass('btn-danger')
                    .addClass('btn-success');

            }


            $('#successMessage').text(message);


            $('#successModal').modal('show');

        }

    </script>



    <!-- ===================================================== -->
    <!-- COMMON DELETE MODAL SCRIPT -->
    <!-- ===================================================== -->

    <script>

        let deleteForm = null;


        // Delete button click

        $(document).on('click', '.deleteBtn', function () {

            // Current delete form

            deleteForm = $(this).closest('form');


            // Get message

            let message = $(this).data('message');


            // Set modal message

            $('#deleteMessage').text(
                message || 'Are you sure you want to delete this record?'
            );


            // Open modal

            $('#deleteConfirmModal').modal('show');

        });



        // Confirm Delete button

        $(document).on('click', '#confirmDeleteBtn', function () {

            if (deleteForm) {

                deleteForm.submit();

            }

        });



        // Modal close hone ke baad form clear

        $('#deleteConfirmModal').on('hidden.bs.modal', function () {

            deleteForm = null;

        });

    </script>


</body>

</html>