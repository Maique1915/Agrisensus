<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PerfilGerencial[]|\Cake\Collection\CollectionInterface $perfis
 */

use Cake\Routing\Router;

$this->assign('title', 'Perfis Gerenciais');
?>
<div class="header">
    <h1>Perfis Gerenciais dos Produtores</h1>
    <p>Visualize e gerencie as informações gerenciais de cada produtor.</p>
</div>

<div class="list-container">
    <!-- Botão "Novo" -->
    <div class="filter-section">
        <?= $this->Html->link('+ Adicionar', ['action' => 'add'], ['class' => 'btn btn-new-producer']) ?>

        <div class="specific-filter-container">
            <div class="input-filter">
                <input type="text" id="specificSearchInput" class="form-control" placeholder="Filtrar por...">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="clearSpecificFilterBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="radio-group horizontal" id="filterColumnSelector">
                <label class="radio-inline"><input type="radio" name="filterColumn" value="0" data-search-type="nome"
                        checked> Produtor</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="1" data-search-type="cpf">
                    CPF</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="perfilGerencialTable" class=" table-profiles display responsive nowrap">
            <thead>
                <tr>
                    <th class="hidden-column">Produtor (Nome)</th>
                    <th class="hidden-column">Produtor (Cpf)</th>
                    <th>Emite Nota?</th>
                    <th>Faz DECLAN?</th>
                    <th>Inscrito INSS?</th>
                    <th>Utilizou Crédito?</th>
                    <th>Dificuldades</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Mensagem para lista vazia -->
                <?php if (empty($perfis)) : ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhum perfil gerencial encontrado.</td>
                    </tr>
                <?php endif; ?>
                <!-- Loop para exibir os dados -->
                <?php foreach ($perfis as $perfil) : ?>
                    <tr>
                        <td class="hidden-column"><?= h($perfil->produtore ? $perfil->produtore->nome : 'N/A') ?>
                        </td>
                        <td class="hidden-column"><?= h($perfil->produtore ? $perfil->produtore->cpf : 'N/A') ?>
                        </td>

                        <td>
                            <?php if ($perfil->possui_nota): ?>
                                <span class="data-tag tag-success">Sim</span>
                            <?php else: ?>
                                <span class="data-tag tag-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($perfil->faz_declan): ?>
                                <span class="data-tag tag-success">Sim</span>
                            <?php else: ?>
                                <span class="data-tag tag-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($perfil->inscrito_inss): ?>
                                <span class="data-tag tag-success">Sim</span>
                            <?php else: ?>
                                <span class="data-tag tag-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                           <?php if ($perfil->utilizou_credito): ?>
                                <span class="data-tag tag-success">Sim</span>
                            <?php else: ?>
                                <span class="data-tag tag-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        
                        <!-- Mostra apenas se há dificuldades e link para ver mais -->
                        <td>
                            <?php if (!empty($perfil->dificuldade_producao) || !empty($perfil->dificuldade_infraestrutura) || !empty($perfil->dificuldade_comercializacao)) : ?>
                                <span class="data-tag tag-success">Sim</span>
                            <?php else: ?>
                                <span class="data-tag tag-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $perfil->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Perfil', 'escape' => false]) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                ['class' => 'btn btn-action btn-delete js-delete-perfil-link', 'title' => 'Excluir Perfil', 'escape' => false, 'data-perfil-id' => $perfil->id, 'data-url' => $this->Url->build(['action' => 'delete', $perfil->id])]
                            ) ?>
                            <?= $this->Form->create(null, ['url' => ['action' => 'delete', $perfil->id], 'id' => 'delete-form-' . $perfil->id, 'class' => 'hidden']) ?>
                            <?= $this->Form->hidden('_method', ['value' => 'DELETE']) ?>
                            <?= $this->Form->end() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('common_datatable'); ?>
<?= $this->Html->script('perfis-gerenciais'); ?>
<?php $this->end(); ?>