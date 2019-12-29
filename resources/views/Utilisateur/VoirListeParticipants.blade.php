  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="idTitreModalListeParticipants">Liste des participants</h4>
        <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;</button>
      </div>
      <div class="modal-body" id="contenuModalVoirListeParticipants">
        <link rel="stylesheet" type="text/css" href="css/Utilisateur/VoirListeParticipants.css">
        <div id="contact-form" class="form-container listeParticipants-container" data-form-container>
        <table class="atelier listeParticipants">
          <thead>
            <tr>
              <th scope="col">Nom</th>
              <th scope="col">Prénom</th>
            </tr>
          </thead>
          <tbody>
            @for($index = 0; $index < count($model->getListeParticipants()); $index ++)
            <tr>
              <td>
                {{$model->getListeParticipants()[$index]-> Nom}}
              </td>
              <td>
                {{$model->getListeParticipants()[$index]-> Prenom}}
              </td>
            </tr>
            @endfor
          </tbody>
        </table>
        </div>

        <!-- //Script -->
        <script>
        $(document).ready( function () {
            $('.listeParticipants').DataTable({
              language: {
                      url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                  }
            });
        });
        </script>
      </div>
      <div class="modal-footer">
        <input id="idAtelierModalVoirListeParticipants" name="idAtelier" value="{{$model->getAtelier()->id}}" hidden />
        @if(Session::get('idTypeDeCompte') >= 2)
        <button type="button" onclick="ImprimerListePresence()" title="Imprimer la liste de présence" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i></button>
        @endif
        <button type="button" class="btn btn-danger bouton-imprimer"  data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer</button>
      </div>
    </div>
  </div>
