<!-- Contenu -->
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="idTitreModal">Voir un conférencier ou une conférencière</h4>
            <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;</button>
        </div>
        <div class="modal-body" id="idContenu">
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <div class="card">
                <div class="box">
                    <div class="img">
                        @if($model->getPhoto() !== "")
                        <img src="/uploads/{{$model->getPhoto()}}" id="imgConferencier">
                            @else
                            <img src="/images/usager.png" id="imgConferencier">
                            @endif
                    </div>
                    <h2>{{$model->getPrenom()." ".$model->getNom() ? : "Aucun nom disponible pour le moment." }}
                        <br>
                        <br>
                        <span id="reformerExpertise">{{$model->getExpertise() ? : "Aucune expertise précisée pour le moment."}}</span></h2>
                    <p> {{$model->getBiographie() ? : "Aucune biographie disponible pour le moment."}}</p>
                    <span>
                        <ul>
                            <li><a id="lienEnveloppe" href="mailto:{{$model->getCourriel() ? : "#"}}"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                        </ul>
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer
            </button>
        </div>
    </div>
</div>

<!-- Style -->
<link rel="stylesheet" type="text/css" href="css/Utilisateur/VoirConferencier.css">
