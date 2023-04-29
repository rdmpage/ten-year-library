# Ten years building a taxonomic library: connecting persistent identifiers for names, publications and people

https://blog.pensoft.net/2023/03/06/bicikl-project-supports-article-collection-in-biodiversity-data-journal-about-use-of-linked-data/

## Introduction

One thing the field of biodiversity informatics has been very good at is creating databases. However, this success in creation has not been matched by success in creating deep links between those databases [Thomas, 2009). Instead we create an ever growing number of silos. An obvious route to “silo-breaking” is the shared use of the same persistent identifiers for the same entities. For example, rather than mint its own identifier for a publication, a database could reuse the existing Digital Object Identifier (DOI) for that publication. This seemingly trivial step of reusing someone else’s identifier opens up numerous possibilities for interconnection, but comes with some risk: what if that persistent identifier does not, in fact, persist? If we cannot trust that an identifier will continue to be maintained and resolve as we expect, then anything we ourselves build upon that identifier is likely to break. Cross linkages between databases are more likely to be made between databases that make efforts to maintain their identifiers [Shorthouse].

DOIs are a well known example of a persistent identifier, widely used to identify academic publications and other digital items, including datasets. They have been adopted by publishers, who routinely include DOIs for articles from other publishers in the lists of literature cited in their own publications. Embedding these identifiers in what are intended to be long-lived versions of record requires a significant degree of trust. In particular, the publishers trust that the persistence of these identifiers will be longer than the ten year media lifespan for web links [Hennessy and Ge]. This identifier persistence, coupled with tools to retrieve machine-readable metadata for items with DOIs has led to an ecosystem of services that depend on DOIs, including the citation graph [open citations], measures of attention [altmetric], and populating bibliographies for researchers [introducing orcid].

DOIs have gained wide acceptance as identifiers of digital publications and data, and have also been adopted for bacterial taxa and their names [Garrity]. However, the taxonomic community went a different route and adopted Life Science Identifiers (LSIDs) for taxonomic names. These identifiers were attractive for several reasons, such as being developed within the life science community, natively supporting RDF, and being free. Core taxonomic databases such as Index Fungorum, International Plant Names Index, and the Index of Organism Names all supported LSIDs, including their novel resolution mechanism. In subsequent years the ability and/or willingness of databases to support LSIDs has declined until few now do so natively (but work arounds such as HTTP resolution are still feasible, such as https://lsid.io). Despite this, LSIDs are still being embedded in taxonomic publications as part of pipelines to register names [Penev]. 

An additional further problem has been the lack of a single, unique identifier for the same taxonomic name. This has been less of an issue for plant and fungal names. New plant names typically have LSIDs issued by IPNI. Due to its origins as a combination of three different databases [Croft] IPNI has multiple LSIDs for some older names, but typically has a single LSID for more recent names. Fungal names have LSIDs issued by Index Fungorum, or URLs issued by Mycobank [Roberts]. These identifiers share the same local identifier (an integer) and so can be regarded as interchangeable.

In zoology the situation is more complex. Registration of new names is managed by ZooBank, which mints LSIDs for new names, and also has LSIDs for some older names. The n records in ZooBank represent a small fraction of described animal species. For example, ION has over 5 million names, each with a LSID. However, this database contains numerous duplicates  and minor variations in spelling that can be regarded as the same name. Clustering these (Page, 2013) reduces the number of names to 4.3 million, still considerably more than in ZooBank, or other name aggregators such as WoRMS [cite Worms], which also support LSIDs. The existence of multiple identifiers for the same thing (a published taxonomic name) greatly complicates attempts to cross-link databases, because it is not obvious which taxonomic name identifier to use. In the absence of a synthesis of these identifiers by the taxonomic community, we may have to rely on third-party identity brokers such as Wikidata [Veen] to manage links between the menagarie of zoological databases.

The less than satisfactory history of persistent identifiers for taxonomic names may suggest that the problem was the choice of identifier (e.g., LSID rather than, say, DOI). But this overlooks the deeper problem that, as implemented, LSIDs offered little of value beyond their persistence. Resolving a LSID typically returned RDF with no external links, that is, no identifiers beyond ones local to the LSID provider. We had, in effect, created a data silo, ironically using the data format that was supposed to underpin the interconnected Semantic Web.

## Putting holes in silos

The goal of the work described here is to make a small hole in taxonomic data silos by linking LSIDs for taxonomic names to DOIs for the works that published those names. Other bibliographic identifiers are also available and relevant, but the focus will be on DOIs. One reason for this focus is that DOIs are a relatively “sticky” identifier that may be connected to other identifiers, most notably ORCID ids for people. Another reason is the role DOIs play in creating the citation graph, that is, the scholarly network linking works to the works that they either cite, or are cited by. It also makes it easier to cite the taxonomic literature. Taxonomists frequency complain about the lack of citations their work receive. Whatever the merits of that complaint, calls to improve citation practices [Benichou, et al., 2022] are unlikely to improve the situation if the taxonomic literature remains disconnected from taxonomic names. How are we to discover what works should be cited for a name if the links between names and literature are hard to discover?

### Storing the mapping

In addition to the challenge of creating these mappings, there is the problem of how to make them available for reuse. Ideally the source taxonomic databases would incorporate them, on the grounds that they would add value to their users, and it would save those databases doing the work themselves. However, this assumes that those databases have the resources to incorporate this additional data, which seems to rarely be the case. Alternative approaches include developing separate, stand alone web sites to make the data available (e.g., BioNames), or simply putting a data dump in a repository.

In 2018 I explored an intermediate approach of using Datasette's to publish a mapping between IPNI names and the literature. This made the data available, wrapped in a generic interface. Hence the data was queryable, but the interface doesn't support any taxonomic-specific queries. 

The recent release of ChecklistBank has provided a way to publish the data to complement existing databases. ChecklistBank includes all the taxonomic checklists used to create the Catalogue of Life, but also enables users to upload their own checklists. This means that we can take a taxonomic checklist, add persistent identifiers for the literature, then upload the augmented data to ChecklistBank as a new dataset (with an appropriate citation to the source database). This augmented checklist can have its own DOI and be citable (hence providing a mechanism to give credit to those doing the annotation). Because the augmented dataset uses the same taxon name identifiers as the original database, this also means that at any point the original data publishers could incorporate literature mapping into their own databases. Likewise, any other database that uses those same taxon name identifiers could also use the mapping. For example the World Flora Online lacks bibliographic identifiers for plant names, but because they include IPNI identifiers for many of the plant names it would be trivial to add these.

ChecklistBank provides a convenient way to store mappings between names and publications, but not for deeper links such as publications to authors. To store these I follow an approached sketched in [Page, 2022 TDWG] where the mappings are stored as triples and published to Zenodo.


## Goals

The goal of this work is to populate a graph that connects LSIDs for taxonomic names to persistent identifiers (e.g., DOis) for publications, which in turn may be connected and ORCIDs for researchers. 

Taxonomic name - work - person
LSID - DOI - ORCID


### Taxonomic scope

For the purposes of this paper I am going to restrict myself to three databases: Index Fungorum, IPNI, and ION. Each of which uses LSIDs as persistent identifiers for taxonomic names. This gives us substantial coverage of animals, plants, and fungi.

### Bibliographic identifier scope

In this work I will focus on "citable" bibliographic identifiers, that is, identifiers that are typically cited by other publications. In practical terms this means DOIs. Taxonomic databases such as ION include article-level data so this is a close match. But databases such as IPNI and IF typically store bibliographic information at the level of individual pages, or sets of pages.

Citations at the page level have been termed "microcitations" and are analogous to what the U.S. legal profession refers to as "point citations" or "pincites". Some bibliographic databases support page-level identifiers. For example, individual pages in BHL have their own unique URL. In cases where there isn't an explicit identifier we can use fragment identifiers [ref] which identify parts of an entity. For instance, an individual page in a PDF can be referred to using the fragment #page=n where n is the position of the page within the PDF, starting from n=1 for the first page. Blocks of text within a page can be identified using TextQuotes or TextPosition identifiers [ref]. These identifiers are standard components of the W3C annotation model, and are supported by tools such as hypothes.is. Locations with a HTML or XML document can be referred to using Path fragments [ref]. Fragment identifiers enable deep within-document linking, but there are issues regarding their fragility. If the document Beijing linked to changes, or has multiple versions, then fragment identifiers may no longer successfully link to the desired content.


### Visualisation

The core output of this work is a set of triples. This makes the data available to anyone who wants to use it, but is likely to be of little use for a casual user. Hence we construct a simple web site to help navigate the data. This tool is not intended to be “yet another taxonomic database”.


## Methods

### Mapping microcitations

Need source metadata to have page numbers, some journals don't e.g. European Journal of Taxonomy in 1,201 articles from 2011 - 2023 only 243 had a page range in the CrossRef metadata.

Sometimes the identifier itself contains information that can be used to map to a record in a taxonomic database. For example we can map the DOI 10.3389/fmicb.2021.737541 maps to record IF xxxx  using the shared fragment 737541. This is an argument against ideological calls for “opaque identifiers”. Providing one is aware that information in an identifier might be misinterpreted, non opaque identifiers (typically based on metadata for the entity being identified) can be a useful aid to making connections between databases.


### Storing mapping



### Triples

We will present this graph as a set of triples of the form LSID schema:basedOn DOI schema:creator ORCID. Rather than use domain specific vocabularies we will use generic terms from https://schema.org and https://bioschemas.org. 

### Storing triples

## Results

### Coverage



## Discussion


In this work I have focussed on "location based" identifiers such as DOIs and LSIDs.  These identifiers specify a location where one can retrieve information about a digital entity, and potentially retrieve that entity itself. Location-based  identifiers emphasise the persistence of resolution (for example through a centralised resolver) but typically make no guarantees that the content returned persists unchanged over time. For example, academic publishers may update the metadata for an article but the DOI remains unchanged. Another approach to persistent identifiers uses cryptographic hashes of the content as the identifier. This has the advantage of ensuring that the data requested hasn't changed (which we can check by comparing the hash identifier with the hash of the data itself). Unlike DOIs and similar identifiers, there is typically no centralised mechanism to resolve hash-based identifiers. Decentralised systems have been developed, but it is unclear if they themselves will persist.

### Broader connections using persistent identifiers

- unpaywall


## References



## Notes

Credit for taxonomists (citation of their work by databases?)

Inclusion of treatments via Zenodo (requires listing all treatments)

Incusion of citaiom graph, lck of graph for phytotaxa and zootaxa (cxoye datasets)

Inclusion of funding information

Link to DNA sequences

Link to TreeBASE

Do we build our own ts or use wikidata?

How do we encourage using these results?

Literature as the greta connector

Interfaces, e.g Miller columns


https://iphylo.blogspot.com/2022/08/can-we-use-citation-graph-to-measure.html



https://iphylo.blogspot.com/2022/08/linking-taxonomic-names-to-literature.html

https://iphylo.blogspot.com/2022/09/does-anyone-cite-taxonomic-treatments.html



