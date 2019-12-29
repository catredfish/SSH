<!-- Contenu -->
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="idTitreModal">Description d'un atelier</h4>
      <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;
      </button>
    </div>
    <div class="modal-body" id="idContenu">
      <div class="card voirDescriptionAteliersAucunEspace">
        <div id="contact-form" class="form-container" data-form-container>
          <div class="input-container">
              <div class="row">

                <!--Description -->
                <div id="descriptionMobile">
                  <table id="pasDeCouleur">
                    <tbody>
                    <tr>
                      <td>
                        <strong>Titre :</strong> {{ $model->getAtelier()->Nom}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Campus :</strong>
                        @if($model->getAtelier()->idCampus == 1)
                          Tous
                        @elseif($model->getAtelier()->idCampus == 2)
                          Gabrielle-Roy
                        @elseif($model->getAtelier()->idCampus == 3 )
                          Félix Leclerc
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Local :</strong> {{ $model->getAtelier()->Endroit}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Date :</strong> {{ $model->getAtelier()->DateAtelier}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Début :</strong> {{ $model->getAtelier()->HeureDebut}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Places :</strong> {{$model->getNombreParticipants()}}{{"/"}}{{$model->getAtelier()->NombreDePlace}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Description :</strong> {{ $model->getAtelier()->Description}}
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div id="vraiDescriptionMobile">
                  <blockquote><p id="voirDescriptionAteliersTexte">{{$model->getAtelier()->Description}}</p></blockquote>
                </div>

                <!-- Numéro du conférencier à supprimer -->
                <input id="id" name="numeroAtelier" value="{{ $model->getAtelier()->id}}" hidden="hidden">
              </div>
              <div class="row submit-row">
                  <button class="btn btn-block submit-form" id="boutonVoirConferenciers" data-toggle="collapse" href="#conferenciers" role="button" aria-expanded="false" aria-controls="conferenciers">Voir les conférenciers et les conférencières</button>
                    <div class="collapse multi-collapse" id="conferenciers">
                      <div class="card card-body" id="cadreVoirConferencier">
                        <table class="tableVoirConferenciers">
                          <tbody>
                          @if(!empty($model->getListeConferenciers()))
                          @foreach($model->getListeConferenciers() as $conferencier)
                            <tr>
                              <td><button type="button" class="btn btn-success tableVoirConferenciers" onclick="voirConferencier({{$conferencier->id}},{{$model->getAtelier()->id}})">{{$conferencier->Prenom}} {{$conferencier->Nom}}</button>
                              
                                  @if(count($model->getListeConferenciers()) > 1)
                                  <br/>
                                  <br/>
                                  @endif
                              
                              </td>
                            </tr>
                          @endforeach
                          @else
                          <p>Aucun conférencier ou conférencière pour cet atelier</p>
                          @endif
                          </tbody>
                        </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer</button>
    </div>
  </div>
  <script src="js/Utilisateur/VoirDescriptionAtelier.js"></script>
</div>