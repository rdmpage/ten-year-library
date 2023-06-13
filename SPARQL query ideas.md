# Stories and queries for triple store and taxonomy






## Plants

Plant synonyms WFO etc.

### Schismatoglottis kotoensis urn:lsid:ipni.org:names:1020748-1
Homotypic name, heterotypic synonym of Schismatoglottis calyptrata according to WFO

### https://wfo-list.rbge.info/wfo-0000306605-2019-05 
- Schismatoglottis calyptrata
- Lots of synonyms, lots of literature 


### urn:lsid:ipni.org:names:77105675-1  Apoballis okadae

### Bibliographies for taxa/names


```
PREFIX tcom:<http://rs.tdwg.org/ontology/voc/Common#> 
PREFIX tn:<http://rs.tdwg.org/ontology/voc/TaxonName#> 

select * where
{
 #VALUES ?name { <urn:lsid:ipni.org:names:77111391-1> }
  #VALUES ?name { <urn:lsid:ipni.org:names:971963-1> }
  
  ?name tn:genusPart "Ornithoboea" . 
         
  # publication
  ?name tcom:publishedIn ?publishedIn .
  ?name tn:nameComplete ?nameComplete .
    OPTIONAL {
	    ?name tcom:publishedInCitation ?publishedInCitation .
    }

  
  
  # other names
  OPTIONAL
  {
  {
    ?name tn:hasBasionym ?x_name .
    ?x_name tcom:publishedIn ?x_publishedIn .
    OPTIONAL {
	    ?x_name tcom:publishedInCitation ?x_publishedInCitation .
    }
    ?x_name tn:nameComplete ?x_nameComplete .
    
    OPTIONAL {
      ?y_name tn:hasBasionym ?x_name .
      ?y_name tcom:publishedIn ?y_publishedIn .
      ?y_name tn:nameComplete ?y_nameComplete .
      
    OPTIONAL {
	    ?y_name tcom:publishedInCitation ?y_publishedInCitation .
    }      

     
    }
    FILTER (?y_name != ?name)
    
  }
  UNION
  {
    ?z_name tn:hasBasionym ?name .
    ?z_name tcom:publishedIn ?z_publishedIn .
   OPTIONAL {
	    ?z_name tcom:publishedInCitation ?z_publishedInCitation .
    }    
    ?z_name tn:nameComplete ?z_nameComplete .
 }   
    }
  
  
}
```



PREFIX tcom:<http://rs.tdwg.org/ontology/voc/Common#> 
PREFIX tn:<http://rs.tdwg.org/ontology/voc/TaxonName#> 

select * where
{
 #VALUES ?name { <urn:lsid:ipni.org:names:77174083-1> }
        VALUES ?taxonName { <urn:lsid:ipni.org:names:1007716-1> }
          
  # publication
   ?taxonName tn:nameComplete ?name .
    OPTIONAL {
	    ?taxonName tcom:publishedIn ?publishedIn .
    }  
    OPTIONAL {
	    ?taxonName tcom:publishedInCitation ?publishedInCitation .
    }
  
  OPTIONAL {
    # Does this name have a basionym?
    ?taxonName tn:hasBasionym ?basionym .
    ?basionym tn:nameComplete ?basionym_name .
    
     OPTIONAL {
	    ?basionym tcom:publishedIn ?basionymPublishedIn .
    } 
    OPTIONAL {
	    ?basionym tcom:publishedInCitation ?basionymPublication .
    }
    
    # Do any other names have the same basionym as this name?
    # to do
    OPTIONAL {
      ?newCombination tn:hasBasionym ?basionym .
      ?newCombination tcom:publishedIn ?newCombinationPublishedIn .
      ?newCombination tn:nameComplete ?newCombinationName.
      
    OPTIONAL {
	    ?newCombination tcom:publishedInCitation ?newCombinationPublication .
    }      

     
    }
    FILTER (?taxonName != ?newCombination)
    
    }
  
	OPTIONAL {
    # Is this name a basionym for another name?
    ?newCombination tn:hasBasionym ?taxonName .
    ?newCombination tn:nameComplete ?newCombinationName.
      
  	OPTIONAL {
	    ?newCombination tcom:publishedIn ?newCombinationPublishedIn .
    }        
    
    OPTIONAL {
	    ?newCombination tcom:publishedInCitation ?newCombinationPublication .
    }
    
    }  
}
 
### Basionyms
 
#### Monticalia libertatis

<urn:lsid:ipni.org:names:963588-1> Monticalia libertatis

Basionym <urn:lsid:ipni.org:names:246054-1> Senecio libertatis

Other name with same basionym <urn:lsid:ipni.org:names:909457-1> Pentacalia libertatis


### WFO status

Subtree with status, note use of ‘\’ to simply query

```
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX wfo: <https://list.worldfloraonline.org/terms/>
PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX schema: <http://schema.org/>

SELECT ?root_name ?parent_name ?child_name ?status
WHERE {
  VALUES ?root_name { "Monticalia" }
  ?r_name wfo:fullName ?root_name .
  ?root wfo:hasName ?r_name . 
  
  ?child dcterms:isPartOf+ ?root .
  ?child dcterms:isPartOf ?parent .
  ?child wfo:hasName/wfo:fullName ?child_name .
  ?parent wfo:hasName/wfo:fullName ?parent_name .
  
  OPTIONAL {
    ?child wfo:editorialStatus ?status .
  }
    
}
order by ?status
```



## Fungi

### Example with lots of synonyms linked to one basionym “Wilsonomyces carpophilus”

https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?mode=Info&id=763997

Wilsonomyces carpophilus

Wilsonomyces carpophilus	127651-143168
Clasterosporium carpophilum	445686
Coryneum carpophilum	285817
Sciniatosporium carpophilum	323183	Q99865011
Sporocadus carpophilus	116044
Stigmina carpophila	306481	Mycol. Pap. 72: 56 (1959)
Helminthosporium carpophilum Lev. 1843	143168
Thyrostroma carpophilum (Lev.) B. Sutton 1997	443000 Arnoldia 14: 34 (1997) see http://bsm4.snsb.info/BSM-Mycology/Dali//DALIdatabase_DALI_List.cfm and http://bsm4.snsb.info/BSM-Mycology/Dali//DALIdatabase_DALI_Details.cfm?ListNumber=4015


## People

```
PREFIX schema: <http://schema.org/>
SELECT ?name ?orcid ?title ?work 
FROM <https://orcid.org>
WHERE
{
  ?affiliation schema:name "Royal Botanic Garden Edinburgh" .
  ?person schema:affiliation ?affiliation .
  ?person schema:name ?name .
  ?work schema:creator ?person .
  ?work schema:name ?title .
  BIND( REPLACE( STR(?person),"https://orcid.org/","" ) AS ?orcid). 
}
```

```
PREFIX schema: <http://schema.org/>
SELECT ?givenName ?familyName ?orcid ?title ?work
FROM <https://orcid.org>
WHERE
{
  ?affiliation schema:identifier ?identifier .
  ?identifier schema:propertyID "RINGGOLD" .
  ?identifier schema:value "41803" . 
  
  ?person schema:affiliation ?affiliation .
  ?person schema:givenName ?givenName .
  ?person schema:familyName ?familyName .  
  
  ?work schema:creator ?person .
  ?work schema:name ?title .
  BIND( REPLACE( STR(?person),"https://orcid.org/","" ) AS ?orcid). 
}
```


## Images

```
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX schema: <http://schema.org/>
SELECT *
FROM <https://zenodo.org>
WHERE
{
  ?image schema:isPartOf <https://doi.org/10.37520/aemnp.2021.027> .
  ?image rdf:type schema:ImageObject .
  ?image schema:thumbnailUrl ?thumbnailUrl .
  ?image schema:name ?name .
}
```


## Types

Searching for plant specimens in GBIf can be a challenge as people cite collector numbers, not barcodes. GBIF’s search interface is pretty poor at handling this. Can try and match institute and collector

[institutionCode=MO&recordNumber=Croat 56925](http://api.gbif.org/v1/occurrence/search?institutionCode=MO&recordNumber=Croat%2056925)

recordNumber can be just the number, or collector and number. GBIF doesn’t do fuzzy match of recordedBy, making that field not much use.


### Lessingianthus cipoensis Dematt.

http://localhost/~rpage/lois-kg/www/?uri=urn:lsid:ipni.org:names:77121435-1

IPNI has type G.Hatschbach 30041, MBM (holo)

This is in GBIF as https://www.gbif.org/occurrence/1095391277 BRA:MBM:MBM:0000023220 as Lessingianthus brevipetiolatus Found dates to get match by looking at paper https://www.ingentaconnect.com/content/nhn/blumea/2012/00000057/00000002/art00003?crawler=true Not labelled as a type.

### Lessingianthus paraguariensis Dematt.

Three occurrences in GBIF are types, not labelled as such.

### Holotype of Pandanus sikassoensis Huynh [family PANDANACEAE]

JSTOR has https://plants.jstor.org/stable/10.5555/al.ap.specimen.p00836316 P00836316 as holotype of Pandanus sikassoensis, but also identified as Pandanus senegalensis

GBIF has just the Pandanus senegalensis id, and no info that it is a type, but this is in the RAW Darwin Core as https://api.gbif.org/v1/occurrence/1019561487/fragment as two dwc:Identification (check Paris RDF as well).

### Galeoglossum cactorum Chávez-Rendón, Avendaño & Sánchez 1604, MEXU (holo)

http://localhost/~rpage/lois-kg/www/?uri=urn:lsid:ipni.org:names:77115370-1

In GBIF at least twice (BOLD mined from GenBank and Mexican dataset), GenBank sequence FN645940 linked to publication (but no identifier).

### Hollandaea diabolica A.J.Ford & P.H.Weston

http://localhost/~rpage/lois-kg/www/?uri=urn:lsid:ipni.org:names:77124882-1

B.Hyland 25914RFK

B.Hyland 25914RFK, BRI (holo) https://www.gbif.org/occurrence/2418843057 (not labelled as type)
B.Hyland 25914RFK, CNS (iso) https://www.gbif.org/occurrence/994070942 (not labelled)
B.Hyland 25914RFK, NSW (iso) ?

### Teagueia barbeliana L.Jost & Shepard

http://localhost/~rpage/lois-kg/www/?uri=urn:lsid:ipni.org:names:77112078-1

L.Jost 5132, QCA (holo)
L.Jost 5132, QCNE (iso)

L.Jost 5132, QCA (holo) is in JSTOR https://plants.jstor.org/stable/10.5555/al.ap.specimen.qca205659?searchUri=filter%3Dnamewithsynonyms%26so%3Dps_group_by_genus_species%2Basc%26Query%3DTeagueia

Specimen with same details in MO in GBIF, but not flagged as a type: https://www.gbif.org/occurrence/1258002041

### Hanguana loi (type in Kew and GBIF labelled as another species)

Hanguana loi described http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.1007/s12225-012-9358-4 the type is https://www.gbif.org/occurrence/912553032 http://apps.kew.org/herbcat/detailsQuery.do?barcode=K000710125 (labelled as Hanguana malayana ).

### Zingiber phillippsiae

http://localhost/~rpage/lois-kg/www/?uri=urn:lsid:ipni.org:names:1012083-1

https://www.gbif.org/occurrence/47864336 
Catalogue Number: J.Mood398
Recorded by J.Mood

Note the non-standard way of storing collector info



## Spreadsheet-style results

### Mimic my IPNI app

For a genus we list all names, publications, DOIs, and BHL pages.

```
prefix schema: <http://schema.org/>
PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
prefix oa: <http://www.w3.org/ns/oa#>
select ?name ?nameComplete ?year ?publishedIn ?doi ?bhl
where
{
 VALUES ?genusName { "Malleastrum" } .
  
 ?name tn:genusPart ?genusName .
  
 ?name tn:nameComplete ?nameComplete . 
  OPTIONAL {
 ?name tn:year ?year . 
  }
  
 OPTIONAL {
   ?name tcom:publishedIn ?publishedIn . 
 }
  
  # Do we have a publication?
 OPTIONAL {
   ?name tcom:publishedInCitation  ?publishedInCitation  . 
   ?publishedInCitation schema:sameAs ?work .
   
 
   
   OPTIONAL {
     ?work schema:identifier ?identifier .
     ?identifier schema:propertyID "doi" .
     ?identifier schema:value ?doi .
 }  

 }
  
  # Do we have a link to BHL?
   OPTIONAL {
  	?annotation oa:hasBody ?name .
  	?annotation oa:hasTarget ?target .
    BIND (REPLACE(STR(?target), "https://www.biodiversitylibrary.org/page/","") AS ?bhl)
   }
  
  
  
}
```


## Taxon queries

### People working on a taxon

Given a root, e.g. genus, get subtaxa and list authors or papers

```
prefix dc: <http://purl.org/dc/elements/1.1/>
prefix schema: <http://schema.org/>
prefix tcom: <http://rs.tdwg.org/ontology/voc/Common#>

SELECT *
WHERE
{
VALUES ?root_name {"Haniffia"}
 ?root schema:name ?root_name .
 ?child schema:parentTaxon+ ?root .
 #?child schema:parentTaxon ?parent .
 ?child schema:name ?child_name .
 #?parent schema:name ?parent_name .
  
  # scientific name
  OPTIONAL {
    ?child schema:scientificName ?scientificName .
     ?scientificName tcom:publishedIn ?publishedIn .
   
    # do we have a publication
    OPTIONAL {
      ?scientificName tcom:publishedInCitation ?publishedInCitation .
      ?scientificName tcom:publishedInCitation ?publishedInCitation .
      ?publishedInCitation schema:sameAs ?work .
      ?work schema:name ?name .
      
      # people
      OPTIONAL {
        ?work schema:creator ?role .
        ?role schema:creator ?creator .
        {
        	?creator schema:sameAs ?person .
        	?person dc:title|schema:name ?person_name .
        }
        #UNION
        #{
        #  ?creator schema:name ?person_name .
        #}
        
      }
      
      # images
    }
  }
}
```

### Taxa in a work

Given a work list taxa and associated trees

```
prefix schema: <http://schema.org/>
prefix tcom: <http://rs.tdwg.org/ontology/voc/Common#>


SELECT *
WHERE
{
  VALUES ?work { <https://doi.org/10.3897/phytokeys.1.658> }
         
  # names in publication
  ?publishedInCitation schema:sameAs ?work .
  ?scientificName tcom:publishedInCitation ?publishedInCitation .
 
  # taxa
  ?taxon schema:scientificName ?scientificName .
  ?taxon schema:name ?taxon_name .
  
  # tree
  ?taxon schema:parentTaxon+ ?node .
  ?node schema:name ?node_name .
  OPTIONAL { 
    ?node schema:parentTaxon ?parent .
    ?parent schema:name ?parent_name
  }    
  
  
  
}
```

## Examples to show/expore

### Bad ORCIDs

https://orcid.org/0000-0002-5202-9708 J.A Perez-Taborda seems to combine e two different people, a physicist and a taxonomist

### ORCIDs in CrossRef with no or few pubs in CrossRef

https://api.crossref.org/v1/works/10.1111/jbi.13190 (if papers cites those authors can we then infer ORCIDs apply to those authors (e.g., Bonaventure Sonké has ORCID http://orcid.org/0000-0002-4310-3603 but that profile is empty, if papers by Sonké are cited by that paper, then likely that Sonké is same person).


### Lots of authors with ORCIDs

http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.1002/fedr.201700018. (three authors all with ORCIDs)

http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.1007/s00606-018-1504-5  (three authors all with ORCIDs)

### Interesting people

Keooudone Souvannakhoummane 0000-0003-4875-8307 

运洪 谭 0000-0001-6238-2743



### Authors with empty ORCID profiles but ORCIDs in publications

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0002-0585-5513 Van Truong Do

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0002-8195-6738 Xiaofeng Jin

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0001-8464-8688 Lin Bai

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0001-9197-9805 Jia-chen Hao

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0001-8026-6631 Arjun Tiwari

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0002-5994-8117 Haidar Ali

http://localhost/~rpage/lois-kg/www/?uri=https://orcid.org/0000-0001-9060-0891 Pu Zou

https://orcid.org/0000-0002-6331-3456 Ian (WTF!)

### Authors with ORCIDs not linked to publications

https://orcid.org/0000-0003-1039-7606 (one pub listed but without DOI)
https://orcid.org/0000-0002-1597-1921 (Rafflesia consueloae (Rafflesiaceae), the smallest among giants; a new species from Luzon Island, Philippines with wrong DOI)


## GenBank specimens

### Cyrtochilum meirax (and others)

Whitten 2686 FLAS
FJ565600
FJ565089

https://www.gbif.org/occurrence/1457774952

https://www.ncbi.nlm.nih.gov/pmc/articles/PMC5430592
https://dx.doi.org/10.1186%2Fs40529-017-0164-z

Specimens listed in Excel spreadsheet


## Interesting clade

### Australian genera all closely related

https://tree.opentreeoflife.org/opentree/opentree11.4@mrcaott14863ott486102/Triplarina--Homalocalyx

https://www.gbif.org/species/3177392

http://ispecies.org/?q=Micromyrtus

http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.1071/sb14011

### New Caledonia

http://ispecies.org/?q=Pycnandra

http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.1071/sb09029

## Interesting papers

### A new subfamily classification of the Leguminosae based on a taxonomically comprehensive phylogeny – The Legume Phylogeny Working Group (LPWG)

Lots of authors, lots of ORCIDs http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.12705/661.3

However, only manage to connect 1 ORCID to this work, perhaps because of way it appears in author’s profiles:

ORCIDS linked to this work https://enchanting-bongo.glitch.me/search?q=10.12705%2F661.3

 orcid.org/0000-0002-1569-8849
 orcid.org/0000-0002-7204-0744
 orcid.org/0000-0002-6718-6669
 orcid.org/0000-0003-3212-9688
 orcid.org/0000-0003-4482-0409
 orcid.org/0000-0002-7728-6487
 orcid.org/0000-0003-2135-7650
 orcid.org/0000-0002-9591-3085
 orcid.org/0000-0002-9350-3306
 orcid.org/0000-0001-5547-0796
 orcid.org/0000-0002-5788-9010
 orcid.org/0000-0003-4205-1802
 orcid.org/0000-0001-5112-7077
 orcid.org/0000-0001-9269-7316
 orcid.org/0000-0003-2657-8671
 orcid.org/0000-0002-2500-824X
 orcid.org/0000-0002-5740-3666
 orcid.org/0000-0003-0134-3438
 orcid.org/0000-0002-7875-4510
 orcid.org/0000-0001-5105-7152
 orcid.org/0000-0002-0855-4169
 orcid.org/0000-0002-9765-2907
 orcid.org/0000-0001-7072-2656
 orcid.org/0000-0002-5732-1716
 orcid.org/0000-0002-7940-5435
 orcid.org/0000-0002-4484-3566
 orcid.org/0000-0003-4977-4341
 orcid.org/0000-0002-9644-0566

### A new species of Dalbergia (Fabaceae: Dalbergieae) from Tamil Nadu, India

All authors have ORCIDs http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.11646/phytotaxa.360.3.8


## Related papers

### Oreocharis Vietnam

http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.26492/gbs69(2).2017-08

The “related” papers are all geographically related to “Two new species of Oreocharis (Gesneriaceae) from Northwest Vietnam” 

### Miliusa species from Vietnam

http://localhost/~rpage/lois-kg/www/?uri=https://doi.org/10.1111/j.1756-1051.2013.00219.x



## Queries from linked data fragments work

```
SELECT * WHERE {
  <urn:lsid:ipni.org:names:70029259-1><http://rs.tdwg.org/ontology/voc/TaxonName#authorteam> ?authorteam  .
   ?authorteam <http://rs.tdwg.org/ontology/voc/Team#hasMember> ?member .
   ?member <http://rs.tdwg.org/ontology/voc/Team#index> ?order.
   ?member <http://rs.tdwg.org/ontology/voc/Team#role> ?memberRole.
}



SELECT * WHERE {
  <https://doi.org/10.1663/0007-196x(2003)055[0205:drzans]2.0.co;2> <http://schema.org/creator> ?role .
?role <http://schema.org/creator> ?creator .
   ?role <http://schema.org/roleName> ?roleName .
   ?creator <http://schema.org/name> ?name .
}


SELECT * WHERE {
  <https://doi.org/10.1663/0007-196x(2003)055[0205:drzans]2.0.co;2> <http://schema.org/identifier> ?identifier .
  ?identifier <http://schema.org/value> ?value .
}

PREFIX schema: <http://schema.org/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
SELECT * WHERE {
	?person rdf:type <http://schema.org/Person> .
	?person schema:name ?name .
}

PREFIX schema: <http://schema.org/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX ref: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
SELECT * WHERE {
	?s dc:description ?o .
}

PREFIX schema: <http://schema.org/>
SELECT * WHERE {
	?s schema:name ?name .
}

PREFIX schema: <http://schema.org/>
SELECT * WHERE {
	?s schema:name ?name .
        FILTER(lang(?name)="zh")
}



PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
SELECT * WHERE {
	?name tcom:publishedInCitation ?pub .
        ?name <http://schema.org/name> ?label .
        ?cluster   <http://schema.org/dataFeedElement> ?name .
?pub <http://schema.org/name> ?title .
}


PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
SELECT DISTINCT ?periodical ?issn WHERE {
	?name tcom:publishedInCitation ?pub .
        ?name <http://schema.org/name> ?label .
        ?cluster   <http://schema.org/dataFeedElement> ?name .
?pub <http://schema.org/name> ?title .
?pub <http://schema.org/isPartOf> ?journal . 
?journal   <http://schema.org/name> ?periodical .


PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
SELECT * WHERE {
?s tn:nameComplete "Anisotes spectabilis" .
?s tn:hasBasionym ?basionym . 

?basionym tcom:publishedInCitation ?pub .
?pub <http://schema.org/name> ?title .
       

}

PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
SELECT * WHERE {
	?name tcom:publishedInCitation ?pub .
        ?name <http://schema.org/name> ?label .
        ?cluster   <http://schema.org/dataFeedElement> ?name .
?pub <http://schema.org/name> ?title .
?pub <http://schema.org/datePublished> ?date .
}


# match IPNI authors to publication authors,
# not that RDF means that multiple triples may match some of these queries
# need to think carefully about this

prefix tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
prefix tm: <http://rs.tdwg.org/ontology/voc/Team#>
prefix tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX wdt: <http://www.wikidata.org/prop/direct/>
PREFIX wd: <http://www.wikidata.org/entity/>	
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX schema: <http://schema.org/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
SELECT *
where
{
  # ipni
  
   <urn:lsid:ipni.org:names:77088053-1> tn:authorteam ?authorteam  .
   ?authorteam tm:hasMember ?member .
   ?member tm:index ?order.
   ?member tm:role ?memberRole.
   ?member dc:title ?title .
  
   # my mapping
   <urn:lsid:ipni.org:names:77088053-1> tcom:publishedInCitation ?publication .
  
   # publication
   ?publication schema:creator ?role .
   ?role schema:creator ?creator .
   ?role schema:roleName ?order .
   ?creator schema:name ?name .


}

# publications for an IPNI author
prefix tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
prefix tm: <http://rs.tdwg.org/ontology/voc/Team#>
prefix tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX wdt: <http://www.wikidata.org/prop/direct/>
PREFIX wd: <http://www.wikidata.org/entity/>	
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX schema: <http://schema.org/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
SELECT *
where
{
  # ipni
    ?authorteam tm:hasMember   <urn:lsid:ipni.org:authors:37149-1> .
<urn:lsid:ipni.org:authors:37149-1> dc:title ?title .
    ?name tn:authorteam ?authorteam  .
    ?name tcom:publishedInCitation ?publication .
?publication schema:name ?pubtitle .

}



PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
SELECT * WHERE {
?s tn:genusPart "Begonia" .
?s tn:nameComplete ?nameComplete .

?s tcom:publishedInCitation ?pub .
#?pub <http://schema.org/name> ?title .
OPTIONAL {
?pub dc:title ?title .
}
OPTIONAL {
?pub <http://schema.org/datePublished> ?datePublished .
}
OPTIONAL {
?pub <http://schema.org/name> ?name .
}
OPTIONAL {
?pub <http://schema.org/description> ?description .
}
OPTIONAL {
?pub <http://schema.org/isPartOf> ?container .
?container <http://schema.org/name> ?journal .
}
}



#-----------------------------------------------------------------------------------------
# page images for BioStor article
PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX schema: <http://schema.org/>
SELECT * WHERE {

?identifier schema:value "10.26492/gbs69(1).2017-06" .
?pub schema:identifier ?identifier .
?pub schema:itemListElement ?list .
?list schema:position ?position .
?list schema:item ?item .


}


#-----------------------------------------------------------------------------------------
# Image for specimen with species name 

PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX dwc: <http://rs.tdwg.org/dwc/terms/>
PREFIX dcterms: <http://purl.org/dc/terms/>
SELECT DISTINCT * WHERE {
?s dwc:species "Macrocarpaea bangiana" .

OPTIONAL {
?s dwc:associatedMedia ?media .

}
}

#-----------------------------------------------------------------------------------------
# Image for specimen with species name plus occurrence ID


PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX dwc: <http://rs.tdwg.org/dwc/terms/>
PREFIX dcterms: <http://purl.org/dc/terms/>
SELECT DISTINCT * WHERE {
?s dwc:species "Macrocarpaea bangiana" .
?s dwc:typeStatus ?typeStatus .

OPTIONAL {
?s dwc:associatedMedia ?media .

}
OPTIONAL {
?s dwc:occurrenceID ?occurrenceID .

}
}

#-----------------------------------------------------------------------------------------
# fungal names
PREFIX tn: <http://rs.tdwg.org/ontology/voc/TaxonName#>
PREFIX tcom: <http://rs.tdwg.org/ontology/voc/Common#>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX dwc: <http://rs.tdwg.org/dwc/terms/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX  tpc: <http://rs.tdwg.org/ontology/voc/PublicationCitation#>
SELECT DISTINCT * WHERE {
?s tn:genusPart ?genus .
?s tcom:publishedInCitation ?pub .
?pub tpc:title ?title .
}

#-----------------------------------------------------------------------------------------
# images in a paper, e.g. figures from BLR
PREFIX schema: <http://schema.org/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT * WHERE {
?image schema:isPartOf <https://doi.org/10.3897/phytokeys.3.1131>  .
?image rdf:type <http://schema.org/ImageObject> .
?image schema:thumbnailUrl ?thumbnailUrl .

}


#-----------------------------------------------------------------------------------------
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
SELECT *
WHERE {
 { 
    <https://doi.org/10.3897/phytokeys.18.3713> <http://schema.org/creator> ?person  .
     ?person  rdf:type <http://schema.org/Person>
 }
UNION
 { 
    <https://doi.org/10.3897/phytokeys.18.3713> <http://schema.org/creator> ?role  .
    ?role  rdf:type <http://schema.org/Role> . 
    ?role <http://schema.org/creator> ?person  .
     ?person  rdf:type <http://schema.org/Person> .
 }
?person <http://schema.org/name> ?name  .
}





```
