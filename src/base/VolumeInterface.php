<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace craft\base;

use craft\errors\AssetException;
use craft\errors\VolumeObjectExistsException;
use craft\errors\VolumeObjectNotFoundException;

/**
 * VolumeInterface defines the common interface to be implemented by volume classes.
 *
 * A class implementing this interface should also use [[SavableComponentTrait]] and [[VolumeTrait]].
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
interface VolumeInterface extends SavableComponentInterface
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the URL to the source, if it’s accessible via HTTP traffic.
     *
     * @return string|null The root URL, or `false` if there isn’t one
     */
    public function getRootUrl();

    /**
     * List files.
     *
     * @param string $directory The path of the directory to list files of
     * @param bool   $recursive whether to fetch file list recursively
     *
     * @return array
     */
    public function getFileList(string $directory, bool $recursive): array;

    /**
     * Return the metadata about a file.
     *
     * @param string $uri URI to the file on the volume
     *
     * @return array
     * @throws VolumeObjectNotFoundException if the file cannot be found
     */
    public function getFileMetadata(string $uri): array;

    /**
     * Creates a file.
     *
     * @param string   $path   The path of the file, relative to the source’s root
     * @param resource $stream The stream to file
     * @param array    $config Additional config options to pass to the adapter
     *
     * @throws VolumeObjectExistsException if a file already exists at the path on the Volume
     * @return bool Whether the operation was successful
     */
    public function createFileByStream(string $path, $stream, array $config): bool;

    /**
     * Updates a file.
     *
     * @param string   $path   The path of the file, relative to the source’s root
     * @param resource $stream The new contents of the file as a stream
     * @param array    $config Additional config options to pass to the adapter
     *
     * @return bool Whether the operation was successful
     */
    public function updateFileByStream(string $path, $stream, array $config): bool;

    /**
     * Returns whether a file exists.
     *
     * @param string $path The path of the file, relative to the source’s root
     *
     * @return bool Whether the file exists
     */
    public function fileExists(string $path): bool;

    /**
     * Deletes a file.
     *
     * @param string $path The path of the file, relative to the source’s root
     *
     * @return bool Whether the operation was successful
     */
    public function deleteFile(string $path): bool;

    /**
     * Renames a file.
     *
     * @param string $path    The old path of the file, relative to the source’s root
     * @param string $newPath The new path of the file, relative to the source’s root
     *
     * @throws VolumeObjectExistsException if a file with such a name exists already
     * @throws VolumeObjectNotFoundException if the file to be renamed cannot be found
     * @return bool Whether the operation was successful
     */
    public function renameFile(string $path, string $newPath): bool;

    /**
     * Copies a file.
     *
     * @param string $path    The path of the file, relative to the source’s root
     * @param string $newPath The path of the new file, relative to the source’s root
     *
     * @return bool Whether the operation was successful
     */
    public function copyFile(string $path, string $newPath): bool;

    /**
     * Save a file from the source's uriPath to a local target path.
     *
     * @param string $uriPath
     * @param string $targetPath
     *
     * @return int amount of bytes copied
     */
    public function saveFileLocally(string $uriPath, string $targetPath): int;

    /**
     * Gets a stream ready for reading by a file's URI.
     *
     * @param string $uriPath
     *
     * @throws AssetException if a stream cannot be created
     * @return resource
     */
    public function getFileStream(string $uriPath);

    /**
     * Returns whether a folder exists at the given path.
     *
     * @param string $path The folder path to check
     *
     * @return bool
     */
    public function folderExists(string $path): bool;

    /**
     *
     * Creates a directory.
     *
     * @param string $path The path of the directory, relative to the source’s root
     *
     * @throws VolumeObjectExistsException if a directory with such name already exists
     * @return bool Whether the operation was successful
     */
    public function createDir(string $path): bool;

    /**
     * Deletes a directory.
     *
     * @param string $path The path of the directory, relative to the source’s root
     *
     * @return bool Whether the operation was successful
     */
    public function deleteDir(string $path): bool;

    /**
     * Renames a directory.
     *
     * @param string $path    The path of the directory, relative to the source’s root
     * @param string $newName The new path of the directory, relative to the source’s root
     *
     * @throws VolumeObjectExistsException if a directory with such name already exists
     * @throws VolumeObjectNotFoundException if a directory with such name already exists
     * @return bool Whether the operation was successful
     */
    public function renameDir(string $path, string $newName): bool;
}
