<?php

use JiraRestApi\Issue\Version;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\Version\VersionService;

class VersionTest extends PHPUnit_Framework_TestCase
{
    private $versionName = '1.0.0';
    private $project = 'TEST';

    public function testCreateVersion()
    {
        try {
            $projectService = new ProjectService();
            $project = $projectService->get($this->project);

            $versionService = new VersionService();

            $version = new Version();

            $version->setName($this->versionName)
                ->setDescription('Generated by script')
                ->setReleased(true)
                ->setReleaseDate(new \DateTime())
                ->setProjectId($project->id);

            $res = $versionService->create($version);

            $this->assertEquals($res->name, $this->versionName);
        } catch (JiraException $e) {
            print("Error Occured! " . $e->getMessage());
        }
    }

    /**
     * @depends testCreateVersion
     *
     */
    public function testUpdateProject()
    {
        try {
            $versionService = new VersionService();
            $projectService = new ProjectService();

            $ver = $projectService->getVersion($this->project, $this->versionName);

            // update version
            $ver->setName($ver->name . ' Updated name')
                ->setDescription($ver->description . ' Updated description')
                ->setReleased(false)
                ->setReleaseDate(
                    (new \DateTime())->add(date_interval_create_from_date_string('1 months 3 days'))
                );

            $res = $versionService->update($ver);

            $this->assertEquals($res->name, $ver->name);

            return $ver->name;
        } catch (JiraException $e) {
            print("Error Occured! " . $e->getMessage());
        }
    }

    /**
     * @depends testUpdateProject
     */
    public function testDeleteProject($versionName)
    {
        try {
            $versionService = new VersionService();
            $projectService = new ProjectService();

            $ver = $projectService->getVersion($this->project, $versionName);

            $res = $versionService->delete($ver);

            $this->assertEquals($res, true);
        } catch (JiraException $e) {
            print("Error Occured! " . $e->getMessage());
        }
    }
}
