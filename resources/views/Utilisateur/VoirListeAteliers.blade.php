@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Utilisateur/VoirListeFormations.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section ('content')
<div class="container">
  <input id="inputNumeroOngletSelectionne" hidden="hidden" value="{{$model->getOngletSelectionne()}}">
  <input id="inputNumeroCampusSelectionne" hidden="hidden" value="{{$model->getNumeroCampus()}}">
  <input id="inputDateSelectionnee" hidden="hidden" value="{{$model->getDateSelectionnee()}}">
  <div class="panel with-nav-tabs panel-primary">
    <div class="panel-heading">
      <ul class="nav nav-tabs">
        @if($model->getOngletSelectionne() == 1)
        <li class="active"><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">S'inscrire à un atelier</a></li>
        <li><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste de mes ateliers</a></li>
        <li><a onclick="MiseAJourOnglet(3)" href="#tab3primary" data-toggle="tab">Inscriptions en attente</a></li>
        @elseif($model->getOngletSelectionne() == 2)
        <li><a onclick="MiseAJourOnglet(1)" href="#tab1primary" data-toggle="tab">S'inscrire à un atelier</a></li>
        <li class="active"><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste de mes ateliers</a></li>
        <li><a onclick="MiseAJourOnglet(3)" href="#tab3primary" data-toggle="tab">Inscriptions en attente</a></li>
        @else
        <li><a onclick="MiseAJourOnglet(1)" href="#tab1primary" data-toggle="tab">S'inscrire à un atelier</a></li>
        <li><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste de mes ateliers</a></li>
        <li class='active'><a onclick="MiseAJourOnglet(3)" href="#tab3primary" data-toggle="tab">Inscriptions en attente</a></li>
        @endif
      </ul>
    </div>
    <div class="panel-body">
      <button id='boutonLegende' class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Légende
      </button>
      <div class="collapse" id="collapseExample">
        <div id="legende" class="card card-body">
          <table id="tableLegendeBoutons">
            <thead>
              <tr class="tr-legende">
                <th class="th-legende">Bouton</th>
                <th class="th-legende">Description</th>
              </tr>
            </thead>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btnParticipation btn btn-success"><i class="fa fa-check"></i></button></td>
              <td class="td-legende"><label>Permet de s'inscrire à un atelier</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="bouton-desinscrire btnParticipation btn btn-danger"><i class="fa fa-times"></i></button></td>
              <td class="td-legende"><label>Permet de se désinscrire d'un atelier ou d'une liste d'attente</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button class="btn btn-primary"><i class="fa fa-eye"></i></button></td>
              <td class="td-legende"><label>Permet de voir les informations d'un atelier</label></td>
            </tr>
            <!-- Si l'utilisateur est un administrateur ou bien un employé -->
                            @if(Session::get('idTypeConnexion') == 2 || Session::get('idTypeCompte') >= 2)
            <tr class="tr-legende">
              <td class="td-legende"><button class="btn btn-info bouton-liste-participants"><i class="fa fa-address-card-o" aria-hidden="true"></i></button></td>
              <td class="td-legende"><label>Permet de voir la liste des participants d'un atelier</label></td>
            </tr>
            @endif
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="bouton-conflit btnParticipation btn btn-danger"><i class="fa fa-exclamation"></i></button></td>
              <td class="td-legende"><label>Permet de voir les conflits d'horaire concernant les ateliers auxquels vous êtes inscrit(e)</label></td>
              </tr>
              <tr class="tr-legende">
                <td class="td-legende"><button type="button" class="bouton-liste-attentes btnParticipation btn btn-warning"><i class="fa fa-clock-o"></i></button>  </td>
                <td class="td-legende"><label>Permet de savoir si un atelier est à pleine capacité et de vous ajouter à sa liste d'attente</label></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="tab-content">
            @if($model->getOngletSelectionne() == 1)
            <div class="tab-pane fade active in show" id="tab1primary">
              @else
              <div class="tab-pane fade" id="tab1primary">
                @endif
                <form>
                  <div id="contact-form" class="form-container" data-form-container>
                    <div class="row">
                      <div class="form-title">
                        <div id="titre">Liste des ateliers de formation</div>
                      </div>
                    </div>

                    <!--Trier par date-->
                    <label class="labelInputDate">Choisir une date : </label>
                    <input class="inputDate" type="date" value="{{$model->getDateSelectionnee()}}">

                    <!-- Campus -->
                    <select id="campusListeAteliersDisponibles" class="campus">
                      @foreach($model->getListeCampus() as $campus)
                      @if($model->getNumeroCampus() == $campus->id)
                      <option selected="" value="{{$campus->id}}">{{$campus->Nom}}</option>
                      @else
                      <option value="{{$campus->id}}">{{$campus->Nom}}</option>
                      @endif
                      @endforeach
                    </select>
                    <label  class="campus">Campus : </label>
                    <div class="input-container">
                      @csrf
                    </div>
                    <!-- Liste -->
                    <table class="datatable-atelier atelier table table-hover inscriptions" id="formations">
                      <thead>
                      <tr>
                        <th scope="col" class="min-tablet-l">#</th>
                        <th class='th-titre all' scope="col">Titre</th>
                        <th scope="col" class="min-tablet-l">Campus</th>
                        <th scope="col" class="min-tablet-l">Local</th>
                        <th class='th-date min-tablet-p' scope="col">Date</th>
                        <th scope="col" class="min-tablet-p">Début</th>
                        <th scope="col" class="min-tablet-l">Durée</th>
                        <th scope="col" class="min-tablet-l">Participants</th>
                        <th scope="col" id="thActions" class="all">Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                        @for($index = 0; $index < count($model->getListeAteliersDisponibles()); $index ++)
                        <!-- un atelier est actif lorsque la date de l'atelier est supérieure ou égale à la date d'aujourd'hui -->
                        @if(DateTime::createFromFormat('Y-m-d', $model->getListeAteliersDisponibles()[$index]->DateAtelier) >= DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                        <tr>
                          <th scope="row">{{$index + 1}}</th>
                          <td>{{$model->getListeAteliersDisponibles()[$index]->Nom}}</td>
                          <td>{{$model->getListeCampus()[($model->getListeAteliersDisponibles()[$index]->idCampus) - 1]->Nom}}</td>
                          <td>{{$model->getListeAteliersDisponibles()[$index]->Endroit}}</td>
                          <td>{{$model->getListeAteliersDisponibles()[$index]->DateAtelier}}</td>
                          <td>{{$model->getListeAteliersDisponibles()[$index]->HeureDebut}}</td>
                          <td>{{$model->getListeAteliersDisponibles()[$index]->Duree}}</td>
                          <td>{{$model->getListeAteliersDisponibles()[$index]->NombreDeParticipants}}{{"/"}}{{$model->getListeAteliersDisponibles()[$index]->NombreDePlace}}</td>
                          <td>
                            <button type="button" class="btnParticipation btn btn-success" title="S'incrire à cet atelier" data-toggle="modal" data-target="#modal" onclick="VoirInscriptionAtelier({{$model->getListeAteliersDisponibles()[$index]->id}})" ><i class="fa fa-check"></i></button>
                            <button type="button" title="Voir la description de l'atelier" data-toggle="modal" data-target="#modal" onclick="voirDescriptionAtelier({{$model->getListeAteliersDisponibles()[$index]->id}})" data-toggle="modal" data-target="#modalVoirDescriptionAtelier" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                            <!-- Si l'utilisateur est un administrateur ou bien un employé -->
                            @if(Session::get('idTypeConnexion') == 2 || Session::get('idTypeCompte') >= 2)
                            <button type="button" title="Voir la liste des participants" data-toggle="modal" data-target="#modal" onclick="voirListeParticipants('{{$model->getListeAteliersDisponibles()[$index]->id}}')" data-toggle="modal" data-target="#modalVoirListeParticipants" class="bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                            @endif
                            </td>
                          </tr>
                          @endif
                          @endfor
                          <!--Liste d'ateliers à pleine capacité -->
                          @for($index = 0; $index < count($model->getListeAtelierPleineCapacite()); $index ++)
                          <!-- un atelier est actif lorsque la date de l'atelier est supérieure ou égale à la date d'aujourd'hui -->
                          @if(DateTime::createFromFormat('Y-m-d', $model->getListeAtelierPleineCapacite()[$index]->DateAtelier) >= DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                          <tr>
                            <th scope="row">{{$index + count($model->getListeAteliersDisponibles()) + 1}}</th>
                            <td>{{$model->getListeAtelierPleineCapacite()[$index]->Nom}}</td>
                            <td>{{$model->getListeCampus()[($model->getListeAtelierPleineCapacite()[$index]->idCampus) - 1]->Nom}}</td>
                            <td>{{$model->getListeAtelierPleineCapacite()[$index]->Endroit}}</td>
                            <td>{{$model->getListeAtelierPleineCapacite()[$index]->DateAtelier}}</td>
                            <td>{{$model->getListeAtelierPleineCapacite()[$index]->HeureDebut}}</td>
                            <td>{{$model->getListeAtelierPleineCapacite()[$index]->Duree}}</td>
                            <td>{{$model->getListeAtelierPleineCapacite()[$index]->NombreDeParticipants}}{{"/"}}{{$model->getListeAtelierPleineCapacite()[$index]->NombreDePlace}}</td>
                            <td>
                              <button type="button" class="bouton-liste-attentes btnParticipation btn btn-warning" title="S'incrire à la liste d'attente de cet atelier" data-toggle="modal" data-target="#modal" onclick="VoirInscriptionListeAttentes({{$model->getListeAtelierPleineCapacite()[$index]->id}})" ><i class="fa fa-clock-o"></i></button>
                              <button type="button" title="Voir la description de l'atelier" data-toggle="modal" data-target="#modal" onclick="voirDescriptionAtelier({{$model->getListeAtelierPleineCapacite()[$index]->id}})" data-toggle="modal" data-target="#modalVoirDescriptionAtelier" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                              <!-- Si l'utilisateur est un administrateur ou bien un employé -->
                            @if(Session::get('idTypeConnexion') == 2 || Session::get('idTypeCompte') >= 2)
                              <button type="button" title="Voir la liste des participants" data-toggle="modal" data-target="#modal" onclick="voirListeParticipants('{{$model->getListeAtelierPleineCapacite()[$index]->id}}')" data-toggle="modal" data-target="#modalVoirListeParticipants" class="bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                              @endif
                            </td>
                          </tr>
                          @endif
                          @endfor
                          <!--Liste d'ateliers en conflit -->
                          @for($index = 0; $index < count($model->getListeAteliersEnConflit()); $index ++)
                          <!-- un atelier est actif lorsque la date de l'atelier est supérieure ou égale à la date d'aujourd'hui -->
                          @if(DateTime::createFromFormat('Y-m-d', $model->getListeAteliersEnConflit()[$index]->DateAtelier) >= DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                          <tr>
                            <th scope="row">{{$index + count($model->getListeAteliersEnConflit()) + count($model->getListeAtelierPleineCapacite()) + 1}}</th>
                            <td>{{$model->getListeAteliersEnConflit()[$index]->Nom}}</td>
                            <td>{{$model->getListeCampus()[($model->getListeAteliersEnConflit()[$index]->idCampus) - 1]->Nom}}</td>
                            <td>{{$model->getListeAteliersEnConflit()[$index]->Endroit}}</td>
                            <td>{{$model->getListeAteliersEnConflit()[$index]->DateAtelier}}</td>
                            <td>{{$model->getListeAteliersEnConflit()[$index]->HeureDebut}}</td>
                            <td>{{$model->getListeAteliersEnConflit()[$index]->Duree}}</td>
                            <td>{{$model->getListeAteliersEnConflit()[$index]->NombreDeParticipants}}{{"/"}}{{$model->getListeAteliersEnConflit()[$index]->NombreDePlace}}</td>
                            <td>
                              <input id="input-description-conflit" hidden="hidden" value="{{$model->getListeMessagesAteliersEnConflit()[$index]}}">
                              <button type="button" class="bouton-conflit btnParticipation btn btn-danger" title="Voir la source des conflits pour cet atelier" data-toggle="modal" data-target="#modal" onclick="VoirDescriptionConflit({{$model->getListeAteliersEnConflit()[$index]->id}})"><i class="fa fa-exclamation"></i></button>
                              <button type="button" title="Voir la description de l'atelier" data-toggle="modal" data-target="#modal" onclick="voirDescriptionAtelier({{$model->getListeAteliersEnConflit()[$index]->id}})" data-toggle="modal" data-target="#modalVoirDescriptionAtelier" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                              <!-- Si l'utilisateur est un administrateur ou bien un employé -->
                            @if(Session::get('idTypeConnexion') == 2 || Session::get('idTypeCompte') >= 2)
                              <button type="button" title="Voir la liste des participants" data-toggle="modal" data-target="#modal" onclick="voirListeParticipants('{{$model->getListeAteliersEnConflit()[$index]->id}}')" data-toggle="modal" data-target="#modalVoirListeParticipants" class="bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                              @endif
                            </td>
                          </tr>
                          @endif
                          @endfor
                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
                @if($model->getOngletSelectionne() == 2)
                <div class="tab-pane fade active in show" id="tab2primary">
                  @else
                  <div class="tab-pane fade" id="tab2primary">
                    @endif
                    <form>
                      <div id="contact-form" class="form-container" data-form-container>
                        <div class="row">
                          <div class="form-title">
                            <div id="titre">Liste des ateliers de formation</div>
                          </div>
                        </div>

                        <!--Trier par date-->
                        <label class="labelInputDate">Choisir une date : </label>
                        <input class="inputDate" type="date" value="{{$model->getDateSelectionnee()}}">

                        <!-- Campus -->
                        <select id="campusListeAteliersUtilisateurInscrit" class="campus">
                          @foreach($model->getListeCampus() as $campus)
                          @if($model->getNumeroCampus() == $campus->id)
                          <option selected="" value="{{$campus->id}}">{{$campus->Nom}}</option>
                          @else
                          <option value="{{$campus->id}}">{{$campus->Nom}}</option>
                          @endif
                          @endforeach
                        </select>
                        <label  class="campus">Campus : </label>
                        <div class="input-container">
                          @csrf
                        </div>
                        <!-- Liste -->
                        <table class="datatable-atelier atelier table table-hover annulations" id="formations">
                          <thead>
                          <tr>
                            <th scope="col" class="min-tablet-l">#</th>
                            <th class='th-titre all' scope="col">Titre</th>
                            <th scope="col" class="min-tablet-l">Campus</th>
                            <th scope="col" class="min-tablet-l">Local</th>
                            <th class='th-date min-tablet-p' scope="col">Date</th>
                            <th scope="col" class="min-tablet-p">Début</th>
                            <th scope="col" class="min-tablet-l">Durée</th>
                            <th scope="col" class="min-tablet-l">Participants</th>
                            <th scope="col" id="thActions" class="all">Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                            @for($index = 0; $index < count($model->getListeAteliersUtilisateurInscrit()); $index ++)
                            <!-- un atelier est actif lorsque la date de l'atelier est supérieure ou égale à la date d'aujourd'hui -->
                            @if(DateTime::createFromFormat('Y-m-d', $model->getListeAteliersUtilisateurInscrit()[$index]->DateAtelier) >= DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                            <tr>
                              <th scope="row">{{$index + 1}}</th>
                              <td>{{$model->getListeAteliersUtilisateurInscrit()[$index]->Nom}}</td>
                              <td>{{$model->getListeCampus()[($model->getListeAteliersUtilisateurInscrit()[$index]->idCampus) - 1]->Nom}}</td>
                              <td>{{$model->getListeAteliersUtilisateurInscrit()[$index]->Endroit}}</td>
                              <td>{{$model->getListeAteliersUtilisateurInscrit()[$index]->DateAtelier}}</td>
                              <td>{{$model->getListeAteliersUtilisateurInscrit()[$index]->HeureDebut}}</td>
                              <td>{{$model->getListeAteliersUtilisateurInscrit()[$index]->Duree}}</td>
                              <td>{{$model->getListeAteliersUtilisateurInscrit()[$index]->NombreDeParticipants}}{{"/"}}{{$model->getListeAteliersUtilisateurInscrit()[$index]->NombreDePlace}}</td>
                              <td>
                                <button type="button" class="bouton-desinscrire btnParticipation btn btn-danger" title="Se désinscrire de cet atelier" data-toggle="modal" data-target="#modal" onclick="VoirDesinscriptionAtelier({{$model->getListeAteliersUtilisateurInscrit()[$index]->id}})"><i class="fa fa-times"></i></button>
                                <button type="button" title="Voir la description de l'atelier" data-toggle="modal" data-target="#modal" onclick="voirDescriptionAtelier({{$model->getListeAteliersUtilisateurInscrit()[$index]->id}})" data-toggle="modal" data-target="#modalVoirDescriptionAtelier" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                <!-- Si l'utilisateur est un administrateur ou bien un employé -->
                            @if(Session::get('idTypeConnexion') == 2 || Session::get('idTypeCompte') >= 2)
                                <button type="button" title="Voir la liste des participants" data-toggle="modal" data-target="#modal" onclick="voirListeParticipants('{{$model->getListeAteliersUtilisateurInscrit()[$index]->id}}')" data-toggle="modal" data-target="#modalVoirListeParticipants" class="bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                                @endif
                              </td>
                            </tr>
                            @endif
                            @endfor
                          </tbody>
                        </table>
                      </div>
                    </form>
                  </div>
                  @if($model->getOngletSelectionne() == 3)
                  <div class="tab-pane fade active in show" id="tab3primary">
                    @else
                    <div class="tab-pane fade" id="tab3primary">
                      @endif
                      <form>
                        <div id="contact-form" class="form-container" data-form-container>
                          <div class="row">
                            <div class="form-title">
                              <div id="titre">Liste des ateliers de formation</div>
                            </div>
                          </div>
                          <!--Trier par date-->
                          <label class="labelInputDate">Choisir une date : </label>
                          <input class="inputDate" type="date" value="{{$model->getDateSelectionnee()}}">
                          <!-- Campus -->
                          <select id="campusListeAteliersUtilisateurInscrit" class="campus">
                            @foreach($model->getListeCampus() as $campus)
                            @if($model->getNumeroCampus() == $campus->id)
                            <option selected="" value="{{$campus->id}}">{{$campus->Nom}}</option>
                            @else
                            <option value="{{$campus->id}}">{{$campus->Nom}}</option>
                            @endif
                            @endforeach
                          </select>
                          <label  class="campus">Campus : </label>
                          <div class="input-container">
                            @csrf
                          </div>
                          <!-- Liste -->
                          <table class="datatable-atelier atelier table table-hover attentes" id="formations">
                            <thead>
                              <tr>
                                <th scope="col" class="min-tablet-l">#</th>
                                <th class='th-titre all' scope="col">Titre</th>
                                <th scope="col" class="min-tablet-l">Campus</th>
                                <th scope="col" class="min-tablet-l">Local</th>
                                <th class='th-date min-tablet-p' scope="col">Date</th>
                                <th scope="col" class="min-tablet-p">Début</th>
                                <th scope="col" class="min-tablet-l">Durée</th>
                                <th scope="col" class="min-tablet-l">Rang</th>
                                <th scope="col" id="thActions" class="all">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              @for($index = 0; $index < count($model->getListeAttentes()); $index ++)
                              <!-- un atelier est actif lorsque la date de l'atelier est supérieure ou égale à la date d'aujourd'hui -->
                              @if(DateTime::createFromFormat('Y-m-d', $model->getListeAttentes()[$index]->DateAtelier) >= DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                              <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$model->getListeAttentes()[$index]->Nom}}</td>
                                <td>{{$model->getListeCampus()[($model->getListeAttentes()[$index]->idCampus) - 1]->Nom}}</td>
                                <td>{{$model->getListeAttentes()[$index]->Endroit}}</td>
                                <td>{{$model->getListeAttentes()[$index]->DateAtelier}}</td>
                                <td>{{$model->getListeAttentes()[$index]->HeureDebut}}</td>
                                <td>{{$model->getListeAttentes()[$index]->Duree}}</td>
                                <td>{{$model->getListeAttentes()[$index]->positionListeAttentes}}</td>
                                <td>
                                  <button type="button" class="bouton-desinscrire btnParticipation btn btn-danger" title="Se désinscrire de cette liste d'attente" data-toggle="modal" data-target="#modal" onclick="VoirDesinscriptionListeAttentes({{$model->getListeAttentes()[$index]->id}})" ><i class="fa fa-times"></i></button>
                                  <button type="button" title="Voir la description de l'atelier" data-toggle="modal" data-target="#modal" onclick='voirDescriptionAtelier({{$model->getListeAttentes()[$index]->id}})' data-toggle="modal" data-target="#modalVoirDescriptionAtelier" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                  <!-- Si l'utilisateur est un administrateur ou bien un employé -->
                            @if(Session::get('idTypeConnexion') == 2 || Session::get('idTypeCompte') >= 2)
                                  <button type="button" title="Voir la liste des participants" data-toggle="modal" data-target="#modal" onclick="voirListeParticipants('{{$model->getListeAttentes()[$index]->id}}')" data-toggle="modal" data-target="#modalVoirListeParticipants" class="bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                                  @endif
                                </td>
                              </tr>
                              @endif
                              @endfor
                            </tbody>
                          </table>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal annuler atelier -->
      <div id="sectionPourModale">
        <div class="modal fade" id="modal" role="dialog">
        </div>
      </div>

      <!-- Scripts -->
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
      <script src="js/Utilisateur/VoirListeAteliers.js"></script>
      @endsection
