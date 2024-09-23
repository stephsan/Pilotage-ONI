<fieldset>
    <legend>Effectif du jour</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('eff_theorique') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_theorique">Effectif Théorique<span class="text-danger">*</span></label>
                <input id="eff_theorique" type="number"  class="form-control" name="eff_theorique" min="0" placeholder="Entrer effectif theorique" required autofocus>    
                    @if ($errors->has('eff_theorique'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_theorique') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('eff_present') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_present">Effectif présent<span class="text-danger">*</span></label>
                <input id="eff_present" type="number"  class="form-control" name="eff_present" min="0" placeholder="Entrer effectif présent" required autofocus>    
                    @if ($errors->has('eff_present'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_present') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('eff_absent') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_absent">Effectif absent<span class="text-danger">*</span></label>
                <select id="example-chosen-multiple" name="absents[]" class="select-chosen" data-placeholder="Selectionner les absents" style="width: 250px;" multiple>
                   @foreach ($users as $user )
                         <option value="{{ $user->id }}"> {{ $user->matricule  }} - {{ $user->name  }} {{ $user->prenom  }} </option>
                   @endforeach
                    
                </select>
                {{-- <input id="eff_absent" type="number"  class="form-control" name="eff_absent" min="0" placeholder="Entrer effectif absent" required autofocus>     --}}
                    @if ($errors->has('eff_absent'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_absent') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('eff_conge') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_conge">Effectif en congé<span class="text-danger">*</span></label>
                <input id="eff_conge" type="number"  class="form-control" name="eff_conge" min="0" placeholder="Entrer effectif en congé" required autofocus>    
                    @if ($errors->has('eff_conge'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_conge') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('eff_permission') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_permission">Effectif en permission<span class="text-danger">*</span></label>
                <input id="eff_permission" type="number"  class="form-control" name="eff_permission" min="0" placeholder="Entrer effectif en permission" required autofocus>    
                    @if ($errors->has('eff_permission'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_permission') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('eff_mission') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_mission">Effectif en mission<span class="text-danger">*</span></label>
                <input id="eff_mission" type="number"  class="form-control" name="eff_mission" min="0" placeholder="Entrer effectif en mission" required autofocus>    
                    @if ($errors->has('eff_mission'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_mission') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('eff_maladie') ? ' has-error' : '' }}">
                <label class=" control-label" for="eff_maladie">Effectif malade<span class="text-danger">*</span></label>
                <input id="eff_maladie" type="number"  class="form-control" name="eff_maladie" min="0" placeholder="Entrer effectif malade" required autofocus>    
                    @if ($errors->has('eff_maladie'))
                    <span class="help-block">
                        <strong>{{ $errors->first('eff_maladie') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
    </div>
</fieldset>