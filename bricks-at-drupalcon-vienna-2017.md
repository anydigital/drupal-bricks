How to Content Model in Drupal 8
===

<p><em>This session is the third one in the series, following the <a href="https://events.drupal.org/dublin2016/sessions/hidden-power-drupal-8-core-entity-reference-site-builder-flexible-content">Drupal 8 Hidden Power</a> at DrupalCon Dublin 2016 and <a href="https://events.drupal.org/barcelona2015/sessions/full-flexibility-content-editors-drupal-architectures-and-patterns">Drupal Architectures for Flexible Content</a> at DrupalCon Barcelona 2015. But unlike the previous two, this time we will focus on practical application and demos, exclusively for Drupal 8.</em></p>
<p>Atomic Design gives us a good vision on how <em>to design</em> the systems of components. But when it comes to the real project, things become more complicated and it can be really hard <em>to implement</em>.</p>
<p>Why?</p>
<p>Because it covers the <em>design patterns</em>, not the <em>content building blocks</em>. These two things are closely interrelated but have completely different meaning: first is a view, second is a model. And don&#39;t worry: we are not going to re-implement the atom (wheel)!</p>
<p>Let&#39;s try to create a big picture of content building process, review what we have in Drupal 8 and see how we can benefit from its core features keeping in mind Atomic Design principles.</p>
<p>Finally we will stop talking and go through a nifty Drupal 8 setup giving you desired flexibility.</p>
<!--break-->
<p>The following topics will be highlighted:</p>
<ul>
<li>How to structure a page? In which independent components to split and how granularly?</li>
<li>What is a difference between content items, building blocks and patterns/components?</li>
<li>How to re-use content throughout website? How to render the same content differently depending on the context?</li>
<li>How to organize the nesting of components?</li>
<li>Where is a border between content and layout?</li>
<li>Can layout be treated as a content?</li>
<li>Why Paragraphs module doesn&#39;t work well in all cases?</li>
</ul>
<p>The following modules will be covered:</p>
<ul>
<li><em>Content storage:</em><ul>
<li>Node</li>
<li>Custom Block</li>
<li>Entity Construction Kit</li>
<li>Paragraphs</li>
<li>Fields</li>
<li>Entity Translation</li>
</ul>
</li>
<li><em>Building blocks:</em><ul>
<li>Block Layout</li>
<li>Field Layout</li>
<li>Bricks</li>
<li>View Modes</li>
<li>Entity Reference</li>
<li>Entity Reference Revisions</li>
<li>Dynamic Entity Reference</li>
<li>Layout Discovery</li>
<li>Webform</li>
<li>Views</li>
</ul>
</li>
<li><em>Content editing:</em><ul>
<li>Inline Entity Form</li>
<li>Entity Browser</li>
<li>Entity Reference Live Preview</li>
<li>Contextual Links</li>
<li>Quick Edit</li>
</ul>
</li>
<li><em>Patterns and components:</em><ul>
<li>UI Patterns</li>
<li>Fractal</li>
<li>Pattern Lab</li>
</ul>
</li>
</ul>
<p>In this session I want to share a real experience when designing a content architecture of large multi-lingual and multi-layout websites for <a href="http://www.acronis.com/">enterprise</a>, <a href="http://en.cs.msu.ru/">academics</a> and <a href="https://www.wearewondrous.com/">digital</a>.</p>
<p>These very simple but extremely flexible techniques can be used for ANY Entity type and in almost ANY project. Re-understand your content today and create your own site buidling experience on top of Entity Reference, Layout API, Bricks and their wide contrib ecosystem!</p>
