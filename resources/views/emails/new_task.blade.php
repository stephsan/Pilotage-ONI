<div style="color: #004085; background-color: #cce5ff; border-color: #004085; border-radius: 4px; border-right: 0.2rem solid; border-left: 0.2rem solid; padding: 1rem; width: 70%; border-radius: 4px;">

    <div><h3><i class="fa fa-user"></i> <strong>Bonjour {{ $det['porteur'] }}</strong>,</h3></div>

    <div style="font-size: 1rem;">La  tâche {{ $det['titre_tache']  }} vous a été affectée. <p>Detail : {{ $det['desc_tache'] }}</p> <p style="color: red;" >Date limite de traitement: {{ $det['delais'] }}</p> <p>Bien vouloir consulter les details de la  tâche sur l'outils de pilotage.</p></div>
</div>