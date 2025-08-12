<div class="home-page">
    <h2>Bem vindo!</h2>
    <p>Esta é a sua página inicial.</p>

    <div class="analysis-section">
        <h3>Análise de Dados</h3>

        <div class="analysis-cards-grid">
            <!-- Composição Familiar -->
            <div class="analysis-card">
                <h4>Composição Familiar</h4>
                <p><strong>Média de Dependentes por Produtor:</strong> <?= number_format($avgDependentes, 2) ?></p>

                <!-- Canvas para o gráfico -->
                <canvas id="graficoComposicaoFamiliar"></canvas>
            </div>

            <!-- Mão de Obra -->
            <div class="analysis-card">
                <h4>Mão de Obra</h4>
                <canvas id="graficoMaoDeObra"></canvas>
            </div>

            <!-- Nível de Formalização -->
            <div class="analysis-card">
                <h4>Nível de Formalização</h4>
                <canvas id="graficoFormalizacaoPercentuais"></canvas>
                <br>
                <canvas id="graficoFormalizacaoConhecimento"></canvas>
            </div>

            <!-- Análise da Produção Agrícola -->
            <div class="analysis-card">
                <h4>Análise da Produção Agrícola</h4>

                <canvas id="graficoMaisCultivados"></canvas>
                <br>
                <canvas id="graficoReceitaProdutos"></canvas>
                <br>
                <canvas id="graficoPrecoMedio"></canvas>
                <br>
                <canvas id="graficoPeriodosColheita"></canvas>
            </div>

            <!-- Análise da Pecuária -->
            <div class="analysis-card">
                <h4>Análise da Pecuária</h4>
                <canvas id="chartEspecies"></canvas>
                <canvas id="chartFinalidades" class="mt-4"></canvas>
                <canvas id="chartVacinacao" class="mt-4"></canvas>
            </div>
            <!-- Análise Econômica e de Mercado -->
            <div class="analysis-card">
                <h4>Análise Econômica e de Mercado</h4>
                <canvas id="graficoCredito"></canvas>
                <canvas id="graficoCanaisVenda" style="margin-top:20px;"></canvas>
                <canvas id="graficoInsumos" style="margin-top:20px;"></canvas>
                <canvas id="graficoOrigemInsumos" style="margin-top:20px;"></canvas>
            </div>

            <!-- Análise Geográfica e de Propriedade -->
            <div class="analysis-card">
                <h4>Análise Geográfica e de Propriedade</h4>

                <canvas id="graficoDistribuicaoGeografica"></canvas>
                <canvas id="graficoPosseTerra" style="margin-top:20px;"></canvas>
                <canvas id="graficoTamanhoPropriedade" style="margin-top:20px;"></canvas>
            </div>

            <!-- Análises Cruzadas -->
            <div class="analysis-card">
                <h4>Análises Cruzadas (Insights Avançados)</h4>
                <canvas id="graficoCreditoDificuldades"></canvas>
            </div>
        </div>
    </div>
</div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('home'); ?>
<?php $this->end(); ?>
<style>
    .analysis-section {
        margin-top: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .analysis-section h3 {
        color: #333;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .analysis-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 20px;
    }

    .analysis-card {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .analysis-card h4 {
        color: #555;
        margin-bottom: 15px;
        font-size: 1.2em;
    }

    .analysis-card p,
    .analysis-card ul {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .analysis-card ul {
        list-style: none;
        padding-left: 0;
    }

    .analysis-card ul li {
        margin-bottom: 5px;
    }

    .analysis-card strong {
        color: #333;
    }
</style>