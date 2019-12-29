
@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Administrateur/VoirGestionAteliers.css">
<link rel="stylesheet" type="text/css" href="css/Administrateur/VoirCreationAtelier.css">
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
            <li class="active"><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">Ateliers actifs</a></li>
            <li><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Ateliers archivés</a></li>
            @elseif($model->getOngletSelectionne() == 2)
            <li><a onclick="MiseAJourOnglet(1)" href="#tab1primary" data-toggle="tab" >Ateliers actifs</a></li>
            <li class="active"><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Ateliers archivés</a></li>
            @endif
          </ul>
        </div>
        <div class="panel-body">
          <button id='boutonLegende' class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              Légende
          </button>
          @if($model->getOngletSelectionne() == 1)
          <button id="boutonCreer" class="btn btn-success" onclick="ouvrirModalCreer()" type="button" title="Ajouter un atelier" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span></button>
          <button id="boutonEnvoyerRappelGenerique" onclick="VoirEnvoyerRappelGenerique()" class="btn btn-pink" type="button" title="Envoyer un rappel à tous" data-toggle="modal" data-target="#modal"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
          @endif
          <div class="collapse" id="collapseExample">
              <div id="legende" class="card card-body">
                  <table id="tableLegende">
                      <thead>
                      <tr class="tr-legende">
                          <th class="th-legende" id="thBoutons">Bouton</th>
                          <th class="th-legende">Description</th>
                      </tr>
                      </thead>
                      <tr class="tr-legende">
                          <td class="td-legende"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
                          <td class="td-legende"><label>Permet de créer un atelier</label></td>
                      </tr>
                      <tr class="tr-legende">
                          <td class="td-legende"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></button>  </td>
                          <td class="td-legende"><label>Permet de modifier un atelier</label></td>
                      </tr>
                      <tr class="tr-legende">
                          <td class="td-legende"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></td>
                          <td class="td-legende"><label>Permet de supprimer un atelier</label></td>
                      </tr>
                      <tr class="tr-legende">
                          <td class="td-legende"><button class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                          <td class="td-legende"><label>Permet de voir les informations d'un atelier</label></td>
                      </tr>
                      <tr class="tr-legende">
                          <td class="td-legende"><button class="btn btn-info" id="btnParticipants"><i class="fa fa-address-card-o" aria-hidden="true"></i></button></td>
                          <td class="td-legende"><label>Permet de voir la liste des participants d'un atelier</label></td>
                      </tr>
                      <tr class="tr-legende">
                          <td class="td-legende"><button class="btn btn-pink"><i class="fa fa-envelope-o" aria-hidden="true"></i></button></td>
                          <td class="td-legende"><label>Permet d'envoyer un courriel de rappel de la semaine des sciences humaines à tous les participants</label></td>
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
                          <div class="form-title titreListeGestionAteliers">
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
                        <table class="atelier table table-hover ateliersActifs" id="formations">
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
                                @for($index = 0; $index < count($model->getListeAteliers()); $index ++)
                                <!-- un atelier est actif lorsque la date de l'atelier est supérieure ou égale à la date d'aujourd'hui -->
                                @if(DateTime::createFromFormat('Y-m-d', $model->getListeAteliers()[$index]->DateAtelier) >= DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                                <tr>
                                    <th scope="row">{{$index + 1}}</th>
                                    <td>{{$model->getListeAteliers()[$index]->Nom}}</td>
                                    <td>{{$model->getListeCampus()[($model->getListeAteliers()[$index]->idCampus) - 1]->Nom}}</td>
                                    <td>{{$model->getListeAteliers()[$index]->Endroit}}</td>
                                    <td>{{$model->getListeAteliers()[$index]->DateAtelier}}</td>
                                    <td>{{$model->getListeAteliers()[$index]->HeureDebut}}</td>
                                    <td>{{$model->getListeAteliers()[$index]->Duree}}</td>
                                    <td>{{$model->getListeAteliers()[$index]->NombreDeParticipants}}{{"/"}}{{$model->getListeAteliers()[$index]->NombreDePlace}}</td>
                                    <td>
                                        <button type="button" title="Envoyer un rappel aux participants de cet atelier" data-toggle="modal" data-target="#modal" onclick="VoirEnvoyerRappelSpecifique({{$model->getListeAteliers()[$index]->id}})" class="btn btn-pink"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
                                        <button type="button" title="Voir la description de l'atelier" onclick="voirDescriptionAtelier({{$model->getListeAteliers()[$index]->id}})" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                        <button type="button" title="Voir la liste des participants" onclick="voirListeParticipants('{{$model->getListeAteliers()[$index]->id}}')" data-toggle="modal" data-target="#modal" class="btnParticipants bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                                        <button type="button" title="Modifier cet atelier" onclick="ouvrirModalModifier({{$model->getListeAteliers()[$index]->id}})" class="btnModifier btn btn-warning"  data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></button>
                                        <button type="button" class="btn btn-danger" onclick="ouvrirModalSupprimer({{$model->getListeAteliers()[$index]->id}})" title="Annuler cet atelier" data-toggle="modal" data-target="#modal" ><i class="fa fa-times iconeSupprimer"></i></button>
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
                            <table class="atelier table table-hover ateliersArchives" id="formations">
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
                                  <th scope="col" id="thActionsAlternatifs" class="all">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @for($index = 0; $index < count($model->getListeAteliers()); $index ++)
                                    <!-- un atelier est archivé lorsque la date de l'atelier est inférieur à la date d'aujourd'hui -->
                                    @if(DateTime::createFromFormat('Y-m-d', $model->getListeAteliers()[$index]->DateAtelier) < DateTime::createFromFormat('Y-m-d', date("Y-m-d")))
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td>{{$model->getListeAteliers()[$index]->Nom}}</td>
                                        <td>{{$model->getListeCampus()[($model->getListeAteliers()[$index]->idCampus) - 1]->Nom}}</td>
                                        <td>{{$model->getListeAteliers()[$index]->Endroit}}</td>
                                        <td>{{$model->getListeAteliers()[$index]->DateAtelier}}</td>
                                        <td>{{$model->getListeAteliers()[$index]->HeureDebut}}</td>
                                        <td>{{$model->getListeAteliers()[$index]->Duree}}</td>
                                        <td>{{$model->getListeAteliers()[$index]->NombreDeParticipants}}{{"/"}}{{$model->getListeAteliers()[$index]->NombreDePlace}}</td>
                                        <td>
                                            <button type="button" title="Voir la description de l'atelier" onclick="voirDescriptionAtelier({{$model->getListeAteliers()[$index]->id}})" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                            <button type="button" title="Voir la liste des participants" onclick="voirListeParticipants('{{$model->getListeAteliers()[$index]->id}}','{{$model->getListeAteliers()[$index]->Nom}}')" data-toggle="modal" data-target="#modal" class="btnParticipants bouton-liste-participants btn btn-info"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-danger" onclick="ouvrirModalSupprimer({{$model->getListeAteliers()[$index]->id}})" title="Annuler cet atelier" data-toggle="modal" data-target="#modal" ><i class="fa fa-times iconeSupprimer"></i></button>
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

<!-- Modal annuler atelier -->
<div id="sectionPourModale">
  <div class="modal fade" id="modal" role="dialog">
  </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Administrateur/VoirGestionAteliers.js"></script>
<script src="js/Utilisateur/VoirListeParticipants.js"></script>
@endsection
