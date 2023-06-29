<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <meta name="keywords" content="Design de joias,designer de joias es, alianca de ouro es,brinco de ouro es
        joias para casamento, alianca de ouro, brinco de ouro, melhor designer de joia,melhor designer de joia es,
        joalheria espírito santo,joalheria vitória, joias espírito santo,joias es,
        joias vitória, aliancas em vitória,aliancas es, choker em vitória,choker espírito santo,choker es,
        aliancas espírito santo, joias de casamento vitória,joias de casamento es,joias de casamento espírito santo">
        <meta name="robots" content="index, follow">
        <meta name="description" content="Design único e especial das
                                        joias em Ouro Carla Buaiz Joias, sinônimo de qualidade e exclusividade.
                                        Compre em até 10x: Alianças, Brincos, Colares, Anéis.
                                        Entrega segura e discreta.">
        <meta name="facebook-domain-verification" content="16tubwsenvveymsghajvzspu8xw1r5" />

        <title inertia>{{ config('app.name', 'Carla Buaiz Joias') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
        <meta name="google-site-verification" content="pWOCWNMcOF4nCMG3Ybynwt5jwJr9o4KQJm0Dp-luvdk" />
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-14L4Z81KBF"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-14L4Z81KBF');
        </script>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-951685294"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-951685294');
        </script>
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq ( 'dataProcessingOptions' , []);
            fbq('init', '234802807650698');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id=234802807650698&ev=PageView&noscript=1"/>
        </noscript>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
