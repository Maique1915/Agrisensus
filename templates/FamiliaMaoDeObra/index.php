<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FamiliaMaoDeObra[]|\Cake\Collection\CollectionInterface $familiaMaoDeObras
 */

use Cake\Routing\Router;

$this->assign('title', 'Família e Mão de Obra');
?>
<div class="header">
    <h1>Família e Mão de Obra</h1>
    <p>Visualize a composição familiar e a mão de obra de cada produtor.</p>
</div>

<div class="list-container">
    <!-- Botão "Novo" e Filtros -->
    <div class="filter-section">
        <?= $this->Html->link('+ Adicionar', ['action' => 'add'], ['class' => 'btn btn-new-producer']) ?>

        <!-- Filtros (reutilizando a mesma lógica) -->
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
                <label class="radio-inline"><input type="radio" name="filterColumn" value="0" data-search-type="nome" checked> Produtor</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="1" data-search-type="cpf"> CPF</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="familiaMaoDeObraTable" class="table-profiles display responsive nowrap">
            <thead>
                <tr>
                    <th>Produtor (Nome)</th>
                    <th class="hidden-column">Produtor (CPF)</th>
                    <th>Total de Dependentes</th>
                    <th>Membros da Família na Produção</th>
                    <th>Empregados Contratados</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Mensagem para lista vazia -->
                <?php if ($familiasMaoDeObra->isEmpty()) : ?>
                    <tr>
                        <td colspan="4" class="text-center">Nenhum dado de família e mão de obra encontrado.</td>
                    </tr>
                <?php endif; ?>

                <!-- Loop para exibir os dados -->
                <?php foreach ($familiasMaoDeObra as $familia) : ?>
                    <tr>
                        <!-- Colunas ocultas para busca -->
                        <td><?= h($familia->produtore->nome ?? 'N/A') ?></td>
                        <td class="hidden-column"><?= h($familia->produtore->cpf ?? 'N/A') ?></td>

                        <!-- Colunas visíveis -->
                        <td><?= is_object($familia) ? h($familia->total_dependentes) : 'N/A' ?></td>
                        <td><?= is_object($familia) ? h($familia->qtd_familia_producao) : 'N/A' ?></td>
                        <td><?= is_object($familia) ? h($familia->qtd_empregados) : 'N/A' ?></td>
                        
                        <!-- Coluna de Ações -->
                        <td class="actions">
                            <?= is_object($familia) ? $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $familia->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Dados', 'escape' => false]) : '' ?>
                            <?= is_object($familia) ? $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                [
                                    'class' => 'btn btn-action btn-delete js-delete-familia-link', 
                                    'title' => 'Excluir Dados', 
                                    'escape' => false, 
                                    'data-familia-id' => $familia->id, 
                                    'data-url' => $this->Url->build(['action' => 'delete', $familia->id])
                                ]
                            ) : '' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->append('script'); ?>
<?= $this->Html->script('common_datatable'); ?>
<?= $this->Html->script('familia-mao-de-obra'); // Você precisará criar este JS para a lógica de exclusão ?>
<?php $this->end(); ?>
