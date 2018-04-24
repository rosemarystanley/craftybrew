<?php

declare(strict_types=1);

namespace {

    use Symfony\Component\HttpKernel\Kernel;
    use Symfony\Component\Config\Loader\LoaderInterface;

    class AppKernel extends Kernel
    {
        /**
         * Register the application bundles.
         *
         * @return array|iterable|\Symfony\Component\HttpKernel\Bundle\BundleInterface[]
         */
        public function registerBundles()
        {
            $bundles = [
                new Symfony\Bundle\FrameworkBundle\FrameworkBundle,
                new Symfony\Bundle\SecurityBundle\SecurityBundle,
                new Symfony\Bundle\TwigBundle\TwigBundle,
                new Doctrine\Bundle\DoctrineBundle\DoctrineBundle,
                new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle,
                new FOS\RestBundle\FOSRestBundle,
                new Nelmio\CorsBundle\NelmioCorsBundle,
                new CraftyBrew\WebBundle\WebBundle,
            ];

            if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
                $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle;
                $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
            }

            return $bundles;
        }

        /**
         * Return the path to the root directory of the application.
         *
         * @return string
         */
        public function getRootDir()
        {
            return __DIR__;
        }

        /**
         * Return the path to the cache directory.
         *
         * @return string
         */
        public function getCacheDir()
        {
            return in_array($this->getEnvironment(), ['dev', 'test'])
                ? sys_get_temp_dir() . '/cache/' . $this->getEnvironment()
                : sprintf('%s/var/cache/%s', dirname(__DIR__), $this->getEnvironment());
        }

        /**
         * Return the path to the log directory.
         *
         * @return string
         */
        public function getLogDir()
        {
            return in_array($this->getEnvironment(), ['dev', 'test'])
                ? sys_get_temp_dir() . '/logs'
                : sprintf('%s/var/logs', dirname(__DIR__));
        }

        /**
         * Loads the container configuration.
         *
         * @param LoaderInterface $loader
         *
         * @throws Exception
         */
        public function registerContainerConfiguration(LoaderInterface $loader)
        {
            $loader->load(
                sprintf(
                    '%s/config/config_%s.yml',
                    $this->getRootDir(),
                    $this->getEnvironment()
                )
            );
        }
    }
}
