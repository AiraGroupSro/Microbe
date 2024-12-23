<?php

namespace AiraGroupSro\Microbe;

use AiraGroupSro\Dobee\Dobee;
use AiraGroupSro\MicrobeImageManager\Utils\ImageManagerUtility;
use AiraGroupSro\Microbe\framework\kernel\Kernel;
use AiraGroupSro\Microbe\framework\router\Router;
use AiraGroupSro\Microbe\framework\canonicalizer\Canonicalizer;
use AiraGroupSro\Microbe\framework\tokenizer\Tokenizer;
use AiraGroupSro\Microbe\framework\translator\Translator;
use AiraGroupSro\Microbe\framework\twig\AssetExtension;
use AiraGroupSro\Microbe\framework\twig\CanonicalizeExtension;
use AiraGroupSro\Microbe\framework\twig\PathExtension;
use AiraGroupSro\Microbe\framework\twig\RenderExtension;
use AiraGroupSro\Microbe\framework\twig\GeneralExtension;
use AiraGroupSro\Microbe\framework\twig\TextFunctionsExtension;
use AiraGroupSro\Microbe\framework\twig\TranslateExtension;
use AiraGroupSro\Microbe\framework\parenhancer\Parenhancer;
use AiraGroupSro\Microbe\framework\gatekeeper\Gatekeeper;
use AiraGroupSro\Microbe\framework\formbuilder\Twig\Extension\FormExtension;
use AiraGroupSro\Microbe\framework\flashmessenger\FlashMessenger;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class Microbe{

	public function __construct($configuration = [], $env = 'prod'){
		/// initialize parameters enhancer
		$parenhancer = new Parenhancer(str_replace('%env%',$env,$configuration['parameters']['path']));

		$configuration = $parenhancer->enhanceArray($configuration);

		/// initialize twig
		$loader = new \Twig\Loader\FilesystemLoader($configuration['twig']['pathToTemplates']);
		$twig = new \Twig\Environment($loader, [
			'cache' => $env !== 'prod' ? false : $configuration['twig']['pathToCache'],
		]);

		/// initialize dobee
		$dobee = null;
		if(isset($configuration['dobee']) && $configuration['dobee']['enable'] === true){
			$dobee = new Dobee(
				$parenhancer->enhance(
					file_get_contents($configuration['dobee']['pathToConfiguration'])
				),
				$configuration['dobee']['pathToEntities'],
				$configuration['dobee']['entityNamespace']
			);
		}

		/// initialize image manager
		$imageManager = null;
		if(isset($configuration['wd_image_manager']) && $configuration['wd_image_manager']['enable'] === true){
			$imageManager = new ImageManagerUtility([
				'versions' => $configuration['wd_image_manager']['versions'],
				'upload_root' => $configuration['wd_image_manager']['upload_root'],
				'upload_path' => $configuration['wd_image_manager']['upload_path'],
				'secret' => $configuration['wd_image_manager']['secret'],
				'autorotate' => $configuration['wd_image_manager']['autorotate'],
			]);
		}

        /// initialize mailer
        $mailer = null;
        $mailerConfig = $configuration['mailer'];
        if(isset($mailerConfig) && isset($mailerConfig['enable']) && $mailerConfig['enable'] === true){

            if (isset($mailerConfig['transport']) && $mailerConfig['transport'] === 'smtp' && !empty($mailerConfig['dsn'])) {
                $transport = Transport::fromDsn($mailerConfig['dsn']);
            } else {
				$transport = Transport::fromDsn('sendmail://default?command=/usr/bin/sendmail%20-t');
			}

            $mailer = new Mailer($transport);
        }

		/// initialize gatekeeper
		$gatekeeper = Gatekeeper::getInstance();

		/// initialize flashmessenger
		$flashmessenger = FlashMessenger::getInstance();

		/// initialize router
		$router = new Router($configuration['router']['path'],$configuration['router']['firewall'],$gatekeeper->getRole());

		/// initialize translator
		$translator = null;
		if(isset($configuration['translator']) && $configuration['translator']['enable'] === true){
			$translator = new Translator($configuration['translator']['paths']);
			$twig->addExtension(new TranslateExtension($translator));
		}

		/// add twig extensions
		$twig->addExtension(new AssetExtension(
			$router,
			$configuration['environment'],
			$configuration['theme']
		));
		$twig->addExtension(new CanonicalizeExtension);
		$twig->addExtension(new PathExtension($router));
		$twig->addExtension(new RenderExtension($router));
		$twig->addExtension(new FormExtension($twig,$translator));
		$twig->addExtension(new GeneralExtension);
		$twig->addExtension(new TextFunctionsExtension);

		/// initialize canonicaler
		$canonicalizer = new Canonicalizer;

		/// initialize tokenizer
		$tokenizer = new Tokenizer;

		/// create an array of services to be passed to the application
		$services = [
			'twig' => $twig,
			'dobee' => $dobee,
			'imageManager' => $imageManager,
			'mailer' => $mailer,
			'router' => $router,
			'canonicalizer' => $canonicalizer,
			'tokenizer' => $tokenizer,
			'parenhancer' => $parenhancer,
			'gatekeeper' => $gatekeeper,
			'flashmessenger' => $flashmessenger,
			'translator' => $translator,
		];
		/// run app
		$kernel = new Kernel($services,$configuration);
	}

}
