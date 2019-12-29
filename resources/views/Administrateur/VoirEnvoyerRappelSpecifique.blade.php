<!-- Contenu -->
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="idTitreModal">Envoyer un rappel de participation</h4>
            <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;
            </button>
        </div>
        <div class="modal-body" id="idContenu">
                <div class="card">
                    <div id="contact-form" class="form-container" data-form-container>
                        <div class="input-container">
                            <form>
                                @csrf
                                <div class="row">
                                    <!-- Message de confirmation -->
                                    <p>Voulez-vous vraiment envoyer un courriel de rappel de participation à tous les participants de cet atelier?
                                </div>
                                <div class="row submit-row">
                                    <button type="button" onclick="EnvoyerRappelSpecifique({{$idAtelier}})" class="btn btn-block submit-form">Confirmer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer</button>
        </div>
    </div>
</div>
<script src="js/Administrateur/VoirEnvoyerRappelSpecifique.js"></script>
