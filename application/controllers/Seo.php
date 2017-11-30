<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seo extends CI_Controller {

	public function index()
	{
		$this->sitemap();
	}
	
	public function makeSitemap(){

		// APPPATH will automatically figure out the correct path
		include APPPATH.'libraries/SitemapPHP/Sitemap.php';

		$url = base_url();
		
		// your website url
		//$sitemap = new Sitemap('http://yourwebsite.com');
		$sitemap = new Sitemap($url);
		
		// This will also need to be set by you. 
		// the full server path to the sitemap folder 
		$sitemap->setPath(base_url().'sitemap/');

		// the name of the file that is being written to
		$sitemap->setFilename('mysitemap');
		
		$sitemap->addItem('/');
		$sitemap->addItem('/about');
		$sitemap->addItem('/contact-us');
		$sitemap->addItem('/lookbook');
		$sitemap->addItem('/login');
		$sitemap->addItem('/signup');
		$sitemap->addItem('/collections/fit-guide');
		//$sitemap->addItem('/lookbook');
		// etc etc etc 

	} 
	
	public function sitemap()
    {

        $data = "";//select urls from DB to Array
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap',$data);
    }
}
