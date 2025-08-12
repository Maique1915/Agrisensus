<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Scripts e CSS externos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/colreorder/2.0.0/css/colReorder.dataTables.min.css" />

    <!-- DataTables via CakePHP -->
    <?= $this->Html->css('//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css') ?>

    <title><?= $cakeDescription ?>: <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['style', 'index', 'sidebar', 'form', 'alerts', 'login']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    

</head>

<?= $this->Form->create(null, ['id' => 'csrf-form', 'style' => 'display:none;']) ?>
    <?= $this->Form->end() ?>
<body>

    <div id="flash-message-container">
        <?= $this->Flash->render() ?>
    </div>

    <div id="toast-container" class="toast-container"></div>

    <div class="app-container">
        <?php if ($this->Identity->isLoggedIn()): ?>
            <?= $this->element('sidebar') ?>
        <?php endif; ?>
        <section class="side">
            <?= $this->fetch('content') ?>
        </section>
    </div>
    <footer>
    </footer>
    <!-- Confirmation Modal -->
    <div id="generalConfirmationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 data-modal-title></h5>
                <button type="button" class="close" data-modal-dismiss>&times;</button>
            </div>
            <div class="modal-body">
                <p data-modal-message></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-modal-cancel></button>
                <button type="button" class="btn" data-modal-confirm></button>
            </div>
        </div>
    </div>

    <!-- Alert Modal -->
    <div id="generalAlertDialog" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 data-modal-title></h5>
                <button type="button" class="close" data-modal-dismiss>&times;</button>
            </div>
            <div class="modal-body">
                <p data-modal-message></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-modal-ok></button>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/colreorder/2.0.0/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->Html->script('//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js') ?>
<?= $this->Html->script('app-masks'); ?>
<?= $this->Html->script('modal-manager'); ?>
<?= $this->fetch('script') ?>


</html>