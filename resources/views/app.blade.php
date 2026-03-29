<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('api-docs.title', 'API Documentation') }}</title>
    @php
        $packageManifestPath = public_path('vendor/api-docs/build/manifest.json');
        $hostManifestPath = public_path('build/manifest.json');
        $hasPackageManifest = file_exists($packageManifestPath);
        $hasHostManifest = file_exists($hostManifestPath);
        $isHot = file_exists(public_path('hot'));
    @endphp

    @if($hasPackageManifest)
        @php
            $manifest = json_decode(file_get_contents($packageManifestPath), true);
        @endphp
        @if(isset($manifest['resources/css/app.css']['file']))
            <link rel="stylesheet" href="{{ asset('vendor/api-docs/build/' . $manifest['resources/css/app.css']['file']) }}">
        @endif
        @if(isset($manifest['resources/js/app.jsx']['file']))
            <script type="module" src="{{ asset('vendor/api-docs/build/' . $manifest['resources/js/app.jsx']['file']) }}"></script>
        @endif
    @elseif($isHot || $hasHostManifest)
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @else
        <!-- Vite manifest not found and not in hot mode. Please run 'npm run build' or publish package assets. -->
    @endif
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
