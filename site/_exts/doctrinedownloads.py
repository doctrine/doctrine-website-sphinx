from docutils.parsers.rst import Directive, directives
from docutils import nodes, utils
from string import upper
from pkg_resources import parse_version
import os;

from yaml import load as yaml_load
try:
    from yaml import CLoader as Loader, CDumper as Dumper
except ImportError:
    from yaml import Loader, Dumper

def version_compare(a, b):
    if parse_version(a) < parse_version(b):
        return 1
    else:
        return -1

class doctrinedownloads(nodes.General, nodes.Element):
    pass

class DoctrineDownloads(Directive):
    required_arguments = 0
    optional_arguments = 0
    has_content = True
    option_spec = {
      'file': directives.path,
      'project': directives.unchanged # shortname of the project
    }

    def run(self):
        """
        Implements the directive
        """
        # Get content and options
        file_path = self.options.get('file', None)
        project = self.options.get('project', 'top')

        if not file_path:
            return [self._report('file_path -option missing')]

        projects = yaml_load(open(self._get_directive_path(file_path)).read())

        ret = []
        for p in projects:
            if (p == project):
                project = projects[project]
                node = doctrinedownloads()
                node['project'] = project
                ret.append(node)

        return ret

    def _get_directive_path(self, path):
        """
        Returns transformed path from the directive
        option/content
        """
        source = self.state_machine.input_lines.source(
          self.lineno - self.state_machine.input_offset - 1)
        source_dir = os.path.dirname(os.path.abspath(source))
        path = os.path.normpath(os.path.join(source_dir, path))

        return utils.relative_path(None, path)

def visit_doctrinedownloads_html(self, node):

    self.body.append('<ul class="nav nav-pills project-pills">')
    self.body.append('<li class="latest-version"><a href="#version%s">Latest Version: %s</a></li>' % (node['project']['latest_version'], node['project']['latest_version']))
    self.body.append('<li><a href="%s">Issues</a></li>\n' % (node['project']['issues_link']) )
    self.body.append('<li><a href="http://docs.doctrine-project.org/projects/doctrine-%s/latest/en">Latest Documentation</a></li>\n' % (node['project']['slug']) )
    self.body.append('<li><a href="/api/%s/%s/index.html">Latest API</a></li>\n' % (node['project']['slug'], node['project']['latest_version']) )
    self.body.append('<li><a href="%s">Browse Source</a></li>\n' % (node['project']['browse_source_link']) )
    self.body.append('</ul>')

    self.body.append('<p class="well">%s</p>' % node['project']['description']);

    projectVersions = sorted(node['project']['versions'].keys(), cmp=version_compare)

    for version in projectVersions:
        self.body.append(self.starttag(node, 'div', CLASS='version'))
        versiondata = node['project']['versions'][version];

        if not versiondata:
            continue

        if 'stability' in versiondata:
            stability = versiondata['stability']
        else:
            stability = 'alpha'

        self.body.append('<div class="panel panel-default">')
        self.body.append('<div class="panel-heading">Download %s (%s)<a name="version%s"></div>' % ( version, stability, version ))
        self.body.append('<div class="panel-body">')

        self.body.append('<ul class="nav nav-pills version-pills">');
        self.body.append('<li><a href="http://docs.doctrine-project.org/projects/doctrine-%s/latest/en">Latest Documentation</a></li>\n' % (node['project']['slug']) )
        self.body.append('<li><a href="/api/%s/%s/index.html">API (%s)</a></li>\n' % (node['project']['slug'], version, version) )
        self.body.append('</ul>')

        if 'releases' in versiondata:
            releaseVersions = sorted(versiondata['releases'].keys(), cmp=version_compare)

            self.body.append('<div class="releases">')
            num = 1
            for release in releaseVersions:
                releasedata = versiondata['releases'][release]

                if num == 1:
                    self.body.append('<h4>%s</h4>' % release)

                    self.body.append('<ul class="latest-release">');

                    if 'package_name' in releasedata and versiondata['downloadable']:
                        self.body.append('<li><a href="http://www.doctrine-project.org/downloads/%s">Download Archive</a></li>' % (releasedata['package_name']))

                    if 'pear_install_command' in releasedata:
                        self.body.append('<li><a href="http://pear.doctrine-project.org">Install via PEAR</a> <pre>%s</pre></li>' % (releasedata['pear_install_command']))

                    if 'composer' in releasedata:
                        self.body.append('<li><a href="http://www.packagist.org/packages/doctrine/%s">Composer</a> <pre>{"require": {"doctrine/%s": "%s"}}</pre>' % (node['project']['slug'], node['project']['slug'], release))

                    self.body.append('</ul>');
                else:
                    if num == 2:
                        self.body.append('<h4>Older Versions</h4><ul class="release older-releases">')

                    self.body.append('<li>%s</li>' % (release))

                num = num + 1

            self.body.append('</div></div>')

        self.body.append('</div>')
        self.body.append('</div>')

    raise nodes.SkipNode

def depart_doctrinedownloads_html(self, node):
    self.body.append('</div>')

def setup(app):
    app.add_node(doctrinedownloads,
                 html=(visit_doctrinedownloads_html, depart_doctrinedownloads_html))
    app.add_directive('doctrine-downloads', DoctrineDownloads)
