$(document).ready(function() {

    $('#refinModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var nomeAssociado = button.data('nome')
        var numProposta = button.data('proposta')
        var idProposta = button.data('id-proposta')
        var idAssociado = button.data('associado')
        var modal = $(this)
        modal.find('.modal-title').text(nomeAssociado + ' - ' + numProposta)
        modal.find('#num_proposta').val(numProposta)
        modal.find('#id_proposta').val(idProposta)
        modal.find('#id_associado').val(idAssociado)
        $('#saldo_devedor1').mask('000.000,00', {
            reverse: true
        });
        $('#saldo_devedor2').mask('000.000,00', {
            reverse: true
        });
        $('#saldo_devedor3').mask('000.000,00', {
            reverse: true
        });
        $('#valor_parcela1').mask('000.000,00', {
            reverse: true
        });
        $('#valor_parcela2').mask('000.000,00', {
            reverse: true
        });
        $('#valor_parcela3').mask('000.000,00', {
            reverse: true
        });
    });
});

$(document).ready(function() {
    $('#editarRefinModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var nomeAssociado = button.data('nome')
        var numProposta = button.data('proposta')
        var idRefin = button.data('id-refin')
        var idAssociado = button.data('associado')
        var numContrato1 = button.data('num-contrato1')
        var numContrato2 = button.data('num-contrato2')
        var numContrato3 = button.data('num-contrato3')
        var saldoDevedor1 = button.data('saldo-devedor1')
        var saldoDevedor2 = button.data('saldo-devedor2')
        var saldoDevedor3 = button.data('saldo-devedor3')
        var valorParcela1 = button.data('valor-parcela1')
        var valorParcela2 = button.data('valor-parcela2')
        var valorParcela3 = button.data('valor-parcela3')
        var modal = $(this)
        modal.find('.modal-title').text(nomeAssociado + ' - ' + numProposta)
        modal.find('#num_proposta').val(numProposta)
        modal.find('#id_refin').val(idRefin)
        modal.find('#id_associado').val(idAssociado)
        modal.find('#num_contrato1').val(numContrato1)
        modal.find('#num_contrato2').val(numContrato2)
        modal.find('#num_contrato3').val(numContrato3)
        modal.find('#saldo_devedor_edite1').val(saldoDevedor1)
        modal.find('#saldo_devedor_edite2').val(saldoDevedor2)
        modal.find('#saldo_devedor_edite3').val(saldoDevedor3)
        modal.find('#valor_parcela_edite1').val(valorParcela1)
        modal.find('#valor_parcela_edite2').val(valorParcela2)
        modal.find('#valor_parcela_edite3').val(valorParcela3)

        $('#saldo_devedor_edite1').mask('000.000,00', {
            reverse: true
        });
        $('#saldo_devedor_edite2').mask('000.000,00', {
            reverse: true
        });
        $('#saldo_devedor_edite3').mask('000.000,00', {
            reverse: true
        });
        $('#valor_parcela_edite1').mask('000.000,00', {
            reverse: true
        });
        $('#valor_parcela_edite2').mask('000.000,00', {
            reverse: true
        });
        $('#valor_parcela_edite3').mask('000.000,00', {
            reverse: true
        });
    });
});