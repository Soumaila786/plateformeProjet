@extends('layouts.app')

{{-- Un seul point d'entrée pour les listes "traitées"/historique (approbateur,
     validateur, planificateur — porteur et admin n'en ont pas). --}}
@includeIf('projets.partials.historique._' . auth()->user()->role)
