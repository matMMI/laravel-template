<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function export()
    {
    // Nom du fichier CSV que l'utilisateur téléchargera
    $fileName = "database_export.csv";
    // Créer une réponse de flux
    $response = new StreamedResponse(function () use ($fileName) {
        // Ouvrir un fichier CSV en écriture
        $fileHandle = fopen('php://output', 'w');
        // Récupérer les données de la base de données (ajustez cela en fonction de votre cas d'utilisation)
        $data = DB::table('flexibles')->get();
        // En-tête du fichier CSV
        fputcsv($fileHandle, array_keys((array) $data->first()));
        // Ajouter les données au fichier CSV
        foreach ($data as $row) {
            fputcsv($fileHandle, (array) $row);
        }
        // Fermer le fichier
        fclose($fileHandle);
    }, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ]);
    return $response;
    }
}