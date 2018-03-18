## FAQ

<dl>

<dt>What is a difference with Layout Builder?</dt>
<dd>

  1. Layout Builder (LB) is designed to control any ENTITY layout (per view mode, or per entity).

  2. Bricks is designed to control entity reference FIELD layout (per entity per field).

  IE: You can create Article ENTITY and create Content FIELD on it. then you can control whole entity layout via LB and Content field layout via Bricks. the whole Content field rendered by Bricks will be available then for LB as a block.
</dd>

<dt>Are brick bundles translatable?</dt>
<dd>100% translatable (thanks Entity Translation and ECK). Just mark them as translatable at /admin/config/regional/content-language.</dd>

<dt>Which entity types are supported?</dt>
<dd>Bricks can hold references to any entities - ECK or Paragraphs, doesn’t matter. And Bricks Bootstrap is just an example of using ECK.</dd>

<dt>Does bricks support revisions of the parent entity?</dt>
<dd>Internally Bricks field is a multi-value Entity Reference field => standard revisioning mechanism works. Moreover, Bricks Revisions (core submodule) allows you to revision referenced entities.</dd>

<dt>Is there a reason why i can not just use bricks form widget for the normal paragraphs field?</dt>
<dd>Paragraphs couldn’t be nested using drag and drop! Bricks field allows you to do (like on gif).</dd>

<dt>How to get non-equal column layout, 4-8 in example?</dt>
<dd>Use universal Wrapper brick with custom CSS classes on it. Bootstrap example:
<pre><code>
Wrapper (.row)
|-- Image (.col-sm-4)
|-- Text (.col-sm-8)
</code></pre>
</dd>

</dl>
