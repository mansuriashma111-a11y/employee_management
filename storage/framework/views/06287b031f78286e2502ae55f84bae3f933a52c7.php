

<?php $__env->startSection('title', 'My Leave'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid px-3 px-lg-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>My Leave</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Reason</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>

                            <td>
                                <?php echo e($leave->leave_type); ?>

                            </td>

                            <td>
                                <?php echo e($leave->from_date); ?>

                            </td>

                            <td>
                                <?php echo e($leave->to_date); ?>

                            </td>

                            <td>
                                <?php echo e($leave->reason ?? '-'); ?>

                            </td>
                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>
                            <td colspan="5" class="text-center">
                                No leave records found.
                            </td>
                        </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Desktop\employee_management\resources\views/employee/my_leave.blade.php ENDPATH**/ ?>