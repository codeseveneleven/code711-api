# Code711 API

We published an extension to retrieve the current TYPO3 release of a remote project with a simple link like http://example.com/api/v1/version.

The extensions implements a simple REST API using the micro framework slim. Thanks to B13 and extension b13/slimphp-bridge.

1. Get the extension: https://packagist.org/packages/code711/code711-api

2. Add config: In sites/[site]/config.yaml add:

````yaml
imports:
- resource: EXT:code711_api/Configuration/Routes/Api.yaml
````

3. Add credentials: We use basic authentication to prevent open acces to the current release for security reasons. The credentials could be stored in .env file in project root.

````txt
REST_API_USER=XXX
REST_API_PW=XXX
````

4. Flush cache

5. Test
   For testing REST API you can use the Postman REST Client:
   https://www.postman.com/product/rest-client/
