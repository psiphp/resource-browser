Resource Browser
================

The Resource Browser component is a UI browser *model* for
Puli_ resources.

.. note::

    This package provides only the domain model, it does not provide any
    templating capabilties.

Browsers and Columns
--------------------

Browsers can be represented eiter as panes or columns:

.. image:: browser-types.png

In the resource browser component a *column* is an itreable element containing
a list of resources for a specific path.

For instance to retrive all columns (a column browser) you can:

.. code-block:: php

    <?php

    $browser = Browser::createFromOptions($repository, [ 'path' => '/path/to/something' ]);
    $columns = $browser->getColumns();

Will return 4 columns for each resource in the given path, i.e. the resources
found at `/`, `/path`, `/path/to` and `/path/to/something`.

Whereas:

.. code-block:: php

    <?php

    $browser = Browser::createFromOptions($repository, [ 'path' => '/path/to/something' ]);
    $column = $browser->getCurrentColumn();

Will simply return the column (or pane) for the given path. This is suitable
for a pane browser.

Limiting the number of displayed columns
----------------------------------------

The third argument to the browser is the number of columns to display. The
deafault is 4.

.. code-block:: php

    <?php

    $browser = Browser::createFromOptions($repository, [ 
        'path' => '/path/to/something',
        'nb_columns' => 2,
    ]);
    $columns = $browser->getColumnsForDisplay();

Will return 2 columns: `/path/to` and `/path/to/something`.

Filters
-------

Filters can be used to filter the items (resources) returned by a column. By
default a ``NullFilter`` is used, which does nothing.

.. code-block:: php

    <?php

    class MyNewFilter implements FilterInterface
    {
        public function filter(ResourceCollection $collection): ResourceCollection
        {
            $newCollection = new ArrayResourceCollection();
            foreach ($collection as $resource) {
                if ($resource->getName() !== 'Foobar') {
                    continue;
                }

                $newCollection->add($resource);
            }

            return $newCollection;
        }
    }

.. code-block:: php

    <?php

    $browser = Browser::createFromOptions($repository, [ 
        'path' => '/path/to/something',
        'filter' => new MyNewFilter(),
    ]);
    $items = $browser->getCurrentColumn()->getItems();

The above will show only resources whose name is "Foobar".

You may need to implement several filters at once, in which case you can use
the ``ChainFilter``:

.. code-block:: php

    <?php

    $browser = Browser::createFromOptions($repository, [ 
        'path' => '/path/to/something',
        'filter' => new ChainFilter([
            new MyNewFilter(),
            new FoobarFilter(),
        ]),
    ]);

Simple Twig Example
-------------------

The following is a very simple example for the sake of demonstration:

.. code-block:: jinja

    <div>
        {% for column in browser.columnsForDisplay %}
            <div class="column">
                <h3>{{ column.name }}</h3>
                <ul>
                    {% for resource in column %}
                        <li>{{ column.name }}</li>
                    {% endfor %}
                </ul>
            </div>
        {% endfor %}
    </div>


Combination with the Description component
------------------------------------------

The description component can be used to provide meta information about any
type of object, including resources. Such meta information might include a
title, a link to edit the resource or an image to display which represents the
resource. This therefore allows the browser to access any meta information
that is required, if it is available.

.. _Puli: http://docs.puli.io/en/latest/
