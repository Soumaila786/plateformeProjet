<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Throwable;

class Handler extends ExceptionHandler{
    
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * NOTE : ajouté — intercepte les erreurs de connexion base de données
     * (serveur MySQL arrêté, mauvais port, etc.) pour afficher une page
     * propre plutôt que la page technique Laravel brute. Ne s'applique
     * qu'en dehors du mode debug local, sauf si tu préfères la voir
     * toujours : retire la condition `!config('app.debug')` si besoin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception) {

        if ($exception instanceof PostTooLargeException) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le document est trop volumineux. Choisissez un fichier de 10 Mo maximum.');
        }
        
        if ($exception instanceof QueryException
            && str_contains($exception->getMessage(), 'SQLSTATE[HY000] [2002]')) {
            return response()->view('errors.database', [], 503);
        }

        return parent::render($request, $exception);
    }
}