@extends('layouts.app')

{{-- Un seul point d'entrée pour TOUTES les listes principales de projets
     (admin/porteur/approbateur/validateur/planificateur). Le partial du rôle
     connecté définit lui-même @section('title'), @section('breadcrumb'),
     @section('page-header') et @section('content') — on ne touche jamais
     ce fichier pour adapter un rôle, seulement son partial dans
     projets/partials/liste/. --}}
@includeIf('projets.partials.liste._' . auth()->user()->role)
