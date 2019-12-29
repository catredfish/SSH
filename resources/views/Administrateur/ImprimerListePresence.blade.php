<html>
<head>
  <style>
    body {-webkit-print-color-adjust: exact;}
    .table-liste-presence {
      border-collapse: collapse;
      width: 1000px!important;
      border: 1px solid black;
    }

    .colonne-liste-presence{
      border: 1px solid black;
      width: 50%;
      height: 2.5em;
    }

    .colonne-titre-secondaire{
      text-align: left!important;
    }

    .texte{
      margin-left: 0.5em;
    }

    #titreNomAtelier{
      text-align: center!important;
      font-size: 150%;
      background-color: Silver;
    }
  </style>
</head>
<body>
<table class="table-liste-presence">
<thead>
  <tr>
    <th class="colonne-liste-presence" id="titreNomAtelier" colspan="2">{{$model->getAtelier()->Nom}}</th>
  </tr>
</thead>
<tbody>
  <tr>
    <th class="colonne-liste-presence colonne-titre-secondaire"><p class="texte">Conférencier(ière)s 
    @for($index = 0; $index < count($model->getListeConferenciers()); $index++)
      @if($index == 0)
        {{": "}}{{$model->getListeConferenciers()[$index]->Prenom}} {{$model->getListeConferenciers()[$index]->Nom}}

      @else
        {{"| "}} {{$model->getListeConferenciers()[$index]->Prenom}} {{$model->getListeConferenciers()[$index]->Nom}}

      @endif
    @endfor
    </p></th>
    <th class="colonne-liste-presence colonne-titre-secondaire"><p class="texte">Date : {{date('Y-m-d')}}</p></th>
  </tr>
</tbody>
</table>

<table class="table-liste-presence">
  <thead>
    <tr>
      <th class="colonne-liste-presence">Nom</th>
      <th class="colonne-liste-presence">Signature</th>
    </tr>
  </thead>
  <tbody>
    @foreach($model->getListeParticipants() as $participant)
    <tr>
      <td class="colonne-liste-presence"><p class="texte">{{$participant->Prenom}} {{$participant->Nom}}</p></td>
      <td class="colonne-liste-presence"></td>
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>
