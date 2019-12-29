<!-- Contenu -->
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="idTitreModal">Supprimer un conférencier ou une conférencière</h4>
            <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;
            </button>
        </div>
        <div class="modal-body" id="idContenu">
                <div class="card">
                    <div id="contact-form" class="form-container" data-form-container>
                        <div class="input-container">
                            <form action="/SupprimerConferencier" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Message de confirmation -->
                                    <p>Voulez-vous vraiment supprimer le conférencier ou la conférencière
                                    <strong>{{$model->getPrenom()}} {{$model->getNom() }}</strong> ?</p>

                                    <!-- Numéro du conférencier à supprimer -->
                                    <input id="id" name="Id" value="{{ $model->getId() }}" hidden="hidden">
                                    <input id="onglet" name="ongletChoisi" value="{{ $model->getOnglet() }}" hidden="hidden">
                                    <input id="photo" name="Photo" value="{{ $model->getPhoto() }}" hidden="hidden">
                                </div>
                                <div class="row submit-row">
                                    <button type="submit" class="btn btn-block submit-form">Confirmer</button>
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
